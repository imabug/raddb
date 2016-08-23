
-- Migration script to copy data from the ComplianceReports database to
-- the raddb database
--
use raddb;
SET @@session.foreign_key_checks = 0;

-- Table 'locations'
INSERT IGNORE INTO `locations` (id, `location`) SELECT LocationID, `Location` FROM ComplianceReports.`Location`;

--Table 'manufacturers'
INSERT IGNORE INTO `manufacturers` (id, manufacturer) SELECT ManufacturerID, Manufacturer FROM ComplianceReports.Manufacturer;

--Table 'modalities'
INSERT IGNORE INTO `modalities` (id, modality) SELECT ModalityID, Modality FROM ComplianceReports.Modality;

-- Table 'testers'
INSERT IGNORE INTO `testers` (id, name, initials) SELECT TesterID, TesterName, TesterInitials FROM ComplianceReports.Testers;

-- Table 'testtypes'
INSERT IGNORE INTO `testtypes` (id, test_type) SELECT TypeID, TestType FROM ComplianceReports.TestType;

-- Table 'contactpeople'
INSERT IGNORE INTO `contacts` (id,person,phone,pager,email,location_id,title) SELECT ContactPID, Name, Phone, Pager, Email, LocationID, Title FROM ComplianceReports.ContactPeople;

-- Table 'machines'
INSERT IGNORE INTO `machines` (id, modality_id, description, manufacturer_id, vend_site_id, model, serial_number, manuf_date, install_date, remove_date, location_id, room, machine_status, notes, photo) SELECT MachineID, ModalityID, Description, ManufacturerID, VendSiteID, Model, SerialNumber, ManufDate, InstallDate, RemoveDate, LocationID, Room, `Status`, Notes, Photo FROM ComplianceReports.Machines;

--Table 'tubes'
INSERT IGNORE INTO `tubes` (id, machine_id, housing_model, housing_sn, housing_manuf_id, insert_model, insert_sn, insert_manuf_id, manuf_date, install_date, remove_date, lfs, mfs, sfs, notes, tube_status) SELECT TubeID, MachineID, HousingModel, HousingSN, HousingManufID, InsertModel, InsertSN, InsertManufID, ManufDate, InstallDate, RemoveDate, LFS, MFS, SFS, Notes, `Status` FROM ComplianceReports.Tubes;

-- Table 'testdates'
INSERT IGNORE INTO `testdates` (id, machine_id, test_date, report_sent_date, tester1_id, tester2_id, type_id, notes, accession, report_file_path) SELECT SurveyID, MachineID, TestDate, ReportSentDate, Tester1ID, Tester2ID, TypeID, Notes, Accession, ReportFilePath FROM ComplianceReports.TestDates;

-- Table 'Contact2Machine'
-- INSERT IGNORE INTO `Contact2Machine` (machine_id, contact_id) SELECT MachineID, ContactPID FROM ComplianceReports.Contacts2Machine;

--Table 'operationalnotes'
INSERT IGNORE INTO `opnotes` (id, machine_id, note) SELECT NoteID, MachineID, Note FROM ComplianceReports.OperationalNotes;

-- Table 'recommendations'
INSERT IGNORE INTO `recommendations` (id, survey_id, recommendation, resolved, rec_add_ts, rec_resolve_ts, rec_resolve_date, resolved_by, rec_status, wo_number, service_report_path) SELECT RecID, SurveyID, Recommendation, Resolved, RecAddTS, RecResolveTS, RecResolveDate, ResolvedBy, RecStatus, WONum, ServiceReportPath FROM ComplianceReports.Recommendations;

-- Table 'shieldinglognumbers'
-- INSERT IGNORE INTO `shieldinglognumbers` (id, machine_id, shielding_log_number) SELECT LogID, MachineID, LogNumber FROM ComplianceReports.ShieldingLogNumbers;

-- Table 'Survey2Machine'
-- INSERT IGNORE INTO `Survey2Machine` (survey_id, machine_id) SELECT SurveyID, MachineID FROM ComplianceReports.Survey2Machine;

-- Table 'surveyreports'
-- INSERT IGNORE INTO `surveyreports` (survey_id, report_file_path) SELECT SurveyID, ReportFilePath FROM ComplianceReports.SurveyReports;

-- Table 'gendata'
INSERT IGNORE INTO `gendata` (id, survey_id, tube_id, kv_set, ma_set, time_set, mas_set, add_filt, distance, kV_avg, kv_max, kv_eff, exp_time, exposure, use_flags) SELECT GenID, SurveyID, TubeID, kVset, mAset, Timeset, mAsset, AddFilt, Distance, kVAvg, kVMax, kVEff, ExpTime, `Exp`, UseFlags FROM ComplianceReports.GenData;

SET @@session.foreign_key_checks = 1;
