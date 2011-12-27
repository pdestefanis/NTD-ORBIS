USE FLSMS;

delimiter $$
drop function if exists `isnumeric` $$
create function `isnumeric` (s varchar(255)) returns int deterministic
begin
set @match =
   '^[0-9]+$';

return if(s regexp @match, 1, 0);
end $$

delimiter ;
USE flsms;
delimiter $$

DROP TRIGGER IF EXISTS  populate_parser_db $$

CREATE TRIGGER populate_parser_db 
AFTER INSERT ON flsms.formresponse_responsevalue for each row

MAIN_BLOCK: BEGIN
    
    
    DECLARE done INT DEFAULT 0;
    DECLARE vRAWREPORT_ID integer;
    DECLARE vPHONE_ID integer;
	DECLARE vPHONE_NUMBER varchar(15);
    DECLARE vLOCATION_ID integer;
	DECLARE vDRUG_TREATMENT varchar(4);
    DECLARE vDRUG_ID integer;
    DECLARE vTREATMENT_ID integer;
	DECLARE vQUANTITY integer;
	DECLARE vCOUNT integer;
	DECLARE vCURRDATE DATETIME;
	DECLARE vTEMP varchar(4);
	DECLARE vRESULT_ID varchar(4);
	DECLARE it int default 0;
    

			
	DECLARE responseValCur CURSOR FOR SELECT results_id
            FROM formresponse_responsevalue
            WHERE	FormResponse_id = NEW.FormResponse_id;
			
								
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

	SET vTREATMENT_ID := 0;
	SET vDRUG_ID := 0;
	SET vCOUNT := 0;
   

		SELECT count(*) INTO vCOUNT
			 FROM formresponse_responsevalue
            WHERE	FormResponse_id = NEW.FormResponse_id;
			
		IF vCOUNT > 1 THEN 
			SELECT senderMsisdn INTO vPHONE_NUMBER
								FROM formresponse
								WHERE id = NEW.FormResponse_id;
			
			SELECT phones.id INTO vPHONE_ID 
								FROM ntd.phones 
								WHERE substring(phones.phonenumber FROM -7 )=substring(vPHONE_NUMBER FROM -7) limit 1;
			
			SELECT locations.id INTO vLOCATION_ID
								FROM ntd.locations, ntd.phones
								WHERE location_id = locations.id and phones.id=vPHONE_ID limit 1;
			
			SELECT NOW() INTO vCURRDATE;
			OPEN responseValCur;
			SET it := 0;
			
			FETCH responseValCur into vRESULT_ID;
			WHILE   (it < vCOUNT ) DO 
				

				SELECT VALUE INTO vTEMP FROM FLSMS.RESPONSEVALUE WHERE ID=vRESULT_ID;
				
				
				IF flsms.isnumeric(vTEMP ) THEN
					
					SET vQUANTITY := vTEMP;
				ELSE 
					SET vDRUG_TREATMENT := vTEMP;
					
				END IF;
				
					
				SET it := it+1;
			 	IF it < vCOUNT THEN
					FETCH responseValCur into vRESULT_ID;
				end if;
					
			END WHILE;
			CLOSE responseValCur;
			
			
			IF vPHONE_ID is NULL THEN
				INSERT INTO ntd.PHONES (phonenumber, active) VALUES (vPHONE_NUMBER, 0);
				SELECT phones.id INTO vPHONE_ID 
								FROM ntd.phones 
								WHERE substring(phones.phonenumber FROM -7 )=substring(vPHONE_NUMBER FROM -7) limit 1;
				INSERT INTO ntd.rawreports (raw_message, message_code, created, phone_id)
						VALUES (CONCAT(vDRUG_TREATMENT, ' ',vQUANTITY, ' ', vPHONE_NUMBER), 'FLSMS: Phonenumber not found.', vCURRDATE, vPHONE_ID);	
				LEAVE MAIN_BLOCK;
			END IF;	
			IF vLOCATION_ID is NULL THEN
				INSERT INTO ntd.rawreports (raw_message, message_code, created, phone_id)
						VALUES (CONCAT(vDRUG_TREATMENT, ' ',vQUANTITY, ' ', vPHONE_NUMBER), 'FLSMS: Phonenumber not assigned to a location.', vCURRDATE, vPHONE_ID);	
				LEAVE MAIN_BLOCK;
			END IF;	
			
			IF CHAR_LENGTH(vDRUG_TREATMENT) = 3 THEN 
				SELECT drugs.ID into vDRUG_ID  FROM ntd.drugs where code = vDRUG_TREATMENT;
				IF vDRUG_ID = 0 then
					INSERT INTO ntd.rawreports (raw_message, message_code, created, phone_id)
						VALUES (CONCAT(vDRUG_TREATMENT, ' ',vQUANTITY, ' ', vPHONE_NUMBER), 'FLSMS: Drug not found.', vCURRDATE, vPHONE_ID);	
					LEAVE MAIN_BLOCK;
				END IF;
				
			ELSE 
				IF CHAR_LENGTH(vDRUG_TREATMENT) = 4 THEN
					SELECT treatments.ID into vTREATMENT_ID FROM ntd.treatments where code = vDRUG_TREATMENT;
					IF vTREATMENT_ID = 0 then
						INSERT INTO ntd.rawreports (raw_message, message_code, created, phone_id)
						VALUES (CONCAT(vDRUG_TREATMENT, ' ',vQUANTITY, ' ', vPHONE_NUMBER), 'FLSMS: Treatment not found.', vCURRDATE, vPHONE_ID);	
						LEAVE MAIN_BLOCK;
					END IF;
					
				END IF;
			END IF;
			
			INSERT INTO ntd.rawreports (raw_message, message_code, created, phone_id)
						VALUES (CONCAT(vDRUG_TREATMENT, ' ',vQUANTITY, ' ', vPHONE_NUMBER), 'FLSMS: OK', vCURRDATE, vPHONE_ID);
			
			SELECT id INTO vRAWREPORT_ID from ntd.rawreports WHERE 
							created = vCURRDATE 
							AND phone_id = vPHONE_ID;
			
			INSERT INTO ntd.stats (quantity, created, drug_id, treatment_id, rawreport_id, phone_id, location_id)
						VALUES (vQUANTITY,vCURRDATE,vDRUG_ID, vTREATMENT_ID, vRAWREPORT_ID,vPHONE_ID,  vLOCATION_ID);
		
		END IF;
	 
	

        
END MAIN_BLOCK $$

delimiter ;
USE ntd;
delimiter $$
DROP TRIGGER IF EXISTS  create_flsms_contact $$

CREATE TRIGGER create_flsms_contact 
AFTER INSERT ON ntd.phones for each row

BEGIN
	DECLARE contactid integer;
	
	INSERT INTO flsms.contact (active, name, phoneNumber) 
				VALUES (NEW.active, NEW.name, NEW.phonenumber);
	
	SELECT contact_id INTO contactid from flsms.contact WHERE
						name = NEW.name and phoneNumber = NEW.phonenumber;

	INSERT INTO flsms.groupmembership (contact_contact_id, group_path) 
							
							VALUES (contactid, '/Testers');
END$$

DROP TRIGGER IF EXISTS  update_flsms_contact$$
CREATE TRIGGER update_flsms_contact 
AFTER UPDATE ON ntd.phones for each row

BEGIN
	IF NEW.deleted = 1 then
		UPDATE flsms.contact set active = 0
					WHERE phoneNumber = OLD.phonenumber;
	ELSE
		UPDATE flsms.contact set active = NEW.active, 
				name = NEW.name, 
				phoneNumber = NEW.phonenumber
				WHERE phoneNumber = OLD.phonenumber;
	END IF;
END$$


