/*
 * Scratch pad for creating and testing queries to replace the queries being
 * used in ComplianceReports
 */

# Get the list of machines with surveys in 2016
select machines.id, machines.description,testdates.id,testdates.test_date from machines left join testdates on machines.id = testdates.machine_id where machines.machine_status="Active" and year(testdates.test_date) = "2016" order by testdates.id;

# Get the list of machines without surveys in 2016
select machines.id, machines.description from machines where machines.machine_status="Active" and machines.id not in (select testdates.machine_id from testdates where year(testdates.test_date) = "2016");

# Get the list of pending surveys
select testdates.id,machines.description,testdates.test_date,testdates.accession, testdates.notes from testdates left join machines on testdates.machine_id=machines.id where testdates.test_date > CURDATE();

# Get surveys from previous and current year
# Query still misses the machines that didn't have surveys in the previous year or machines that don't have surveys in the previous or current year
select machines.id, machines.description, previous.id as prevSurveyID, previous.test_date as prevSurveyDate, current.id as currSurveyID, current.test_date as currSurveyDate from machines left join testdates as previous on (machines.id=previous.machine_id) join testdates as current using (machine_id) where year(previous.test_date)='2015' and year(current.test_date)='2016' order by previous.test_date asc;
