DROP FUNCTION IF EXISTS `getChildrenTasksIds`;
CREATE  FUNCTION `getChildrenTasksIds`(`_id` INT) RETURNS varchar(255) CHARSET latin1
BEGIN
	DECLARE  aChildren VARCHAR(255);
	DECLARE id, id2 varchar(200);
	SET aChildren  = _id;
	SET id         = _id;
	SET id2        = id;
	WHILE id2 IS NOT NULL DO
		SET id = NULL;
		SELECT GROUP_CONCAT( taskitem.id ), CONCAT( GROUP_CONCAT( taskitem.ID ),',',aChildren) INTO id, aChildren FROM taskitem WHERE FIND_IN_SET( parent , id2 ) GROUP BY parent;
		SET id2 = id;
	END WHILE;
    return  aChildren;
END;


DROP FUNCTION IF EXISTS `getClosedTaskByTaskList`;
CREATE  FUNCTION `getClosedTaskByTaskList`(`projectId` INT) RETURNS text CHARSET latin1
BEGIN
	DECLARE aTasksIds TEXT;
	DECLARE  aTaskListIds TEXT DEFAULT " ";
    DECLARE taskId,val numeric DEFAULT 0;
	DECLARE done integer default 0;
    declare TaskListIdsCursor cursor for  SELECT  id  FROM task WHERE project_id = projectId  AND is_deleted =0;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
    open TaskListIdsCursor;
    repeat
    	fetch TaskListIdsCursor into val;
           SELECT  GROUP_CONCAT(  ti.id ) INTO aTasksIds  FROM
           (SELECT * FROM taskitem WHERE task_id = val AND status = 1 AND is_deleted =0 AND description  <> ""  ORDER BY updated DESC LIMIT 0,3) ti;
             IF taskId <> val THEN
            	 IF aTasksIds IS NOT NULL THEN
          			SET aTaskListIds = CONCAT( aTasksIds,',',aTaskListIds);
                 END IF;
              END IF;
             SET taskId = val;
    	until done end repeat;
    close TaskListIdsCursor;
    return SUBSTRING(aTaskListIds, 1, CHAR_LENGTH(aTaskListIds) - 2);
END;


DROP FUNCTION IF EXISTS `getDescription`;
CREATE  FUNCTION `getDescription`(`inID` INT) RETURNS varchar(255) CHARSET latin1
begin
  DECLARE gParentID INT DEFAULT 0;
  DECLARE gTmpParentId INT DEFAULT 0;
  DECLARE gDescription VARCHAR(255) CHARACTER SET utf8 DEFAULT '';
  	SELECT parent INTO gParentID FROM taskitem WHERE ID = inID;
 	 Set gTmpParentId = IFNULL(gParentID ,inID);
 	 WHILE gParentID > 7  DO
    	SELECT parent INTO gParentID FROM taskitem WHERE ID = gParentID;
    	Set gTmpParentId = IFNULL(gParentID, gTmpParentId);
 	 END WHILE;
  SELECT description INTO gDescription FROM taskitem WHERE ID =gParentID;
  RETURN gDescription;
end;


DROP FUNCTION IF EXISTS `getPriority`;
CREATE  FUNCTION `getPriority`(`inID` INT) RETURNS varchar(255) CHARSET latin1
begin
  DECLARE gParentID INT DEFAULT 0;
  DECLARE gPriority VARCHAR(255) DEFAULT '';
  SET gPriority = inID;
  SELECT parent INTO gParentID FROM taskitem WHERE ID = inID;
  WHILE gParentID is NOT NULL DO
    SET gPriority = CONCAT(gParentID, '.', gPriority);
    SELECT parent INTO gParentID FROM taskitem WHERE ID = gParentID;
  END WHILE;
  RETURN gPriority;
end;


DROP FUNCTION IF EXISTS `isChild`;
CREATE  FUNCTION `isChild`(`taskId` INT, `parentId` INT) RETURNS int(11)
begin
  DECLARE isChild INT DEFAULT 0;
  DECLARE gParentID INT DEFAULT 0;
  SELECT parent INTO gParentID FROM taskitem WHERE ID = taskId;
  IF gParentID = parentId THEN
      RETURN 1;
  END IF;
checkParent: WHILE gParentID is NOT NULL DO
    SELECT parent INTO gParentID FROM taskitem WHERE ID = gParentID;
    IF gParentID = parentId THEN
       Set isChild = 1;
       LEAVE checkParent;
    END IF;
  END WHILE;

  RETURN isChild;
end