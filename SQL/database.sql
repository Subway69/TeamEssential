DROP DATABASE IF EXISTS FedUni_RA_Register;

CREATE DATABASE FedUni_RA_Register CHARACTER SET utf8 COLLATE utf8_general_ci;
USE FedUni_RA_Register;


GRANT SELECT, INSERT, UPDATE, DELETE
	ON FedUni_RA_Register.*
	TO 'raUser'@'localhost'
	IDENTIFIED BY '67qUfDFLA72Kujkz';



CREATE TABLE Users
(
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(5) NOT NULL, -- Mr/Mrs/Miss/Dr etc.
    first_name VARCHAR(20) NOT NULL,
    middle_name VARCHAR(40),
    last_name VARCHAR(40) NOT NULL,
    email VARCHAR(100),
    address VARCHAR(100) ,
    phone_number VARCHAR(13),
    password VARCHAR(255) NOT NULL,
    day_dob INT,
    month_dob VARCHAR(15),
    year_dob INT,
   -- permisison can be (0) for standard (1) for admin (2) for super admin
    permission INT NOT NULL,
    uniWork INT NOT NULL,
    avail INT DEFAULT 0,
    status  enum('approved','pending') NOT NULL DEFAULT 'pending'
);

INSERT INTO Users(title,first_name,middle_name,last_name,email,address,phone_number,password,day_dob,month_dob,year_dob,permission,uniWork,avail,status) VALUES 
    ("Dr","Michael","Ernest","Munro","michael@RARegister","Admin",0123441,"$2y$12$SYkXvxJhz0VlV30u2VdTuesIPYUp7vBXsar0Rg1hzF71RUZW.oaoK",12,"October",1990,0,0,1,'approved'),/*5246qTSuDYKuvaNb*/
	("Dr","SuperAdmin","SuperAdmin","SuperAdmin","Super@RARegister","SuperAdmin",0123441,"$2y$12$hiH3hkhLZCo2HEYuti594eZFVMiOLLmAXqypJGdQF8gM1E3De2pXS",12,"October",1990,2,0,1,'approved'), /* Q4wsSrGTUf7fUKuR */
    ("Dr","Admin","Admin","Admin","Admin@RARegister","Admin",0123441,"$2y$12$wuBVuvfpZC2y92QHyqMpD..typwiAbP0EBgRLuCT9l1L.IMOhhGly",12,"October",1990,1,0,0,'approved'),/*NprRN6E977rjRpXy */
    ("Mr","Bruce","Batman","Wayne","batman@RARegister","User",0123441,"$2y$12$fY16XWo59gPZP3VmQlp6o.r0bo3y52ZEnYbjxgDY6OwgHxFNIh1Fe",12,"October",1990,0,0,1,'approved'),/*4ZQAZwHbr5fqV3XF*/
    ("Miss","Taylor","Alison","Swift","Taylor@RARegister","User",0123441,"$2y$12$vpOrzLFu/Ao0ANViJDXcIOUyt3XoCGX2TYoCaOuDYmfEexXZHTx7e",12,"October",1990,0,0,0,'approved'),/*eUBTsV37mShLrhfh*/
    ("Miss","Diana","Wonder-Woman","Prince","Diana@RARegister","SuperAdmin",0123441,"$2y$12$lqjL3bDpocywatWoDpuH5eSsaqon3ah5c5MvR6vODphuskXF08MZ.",12,"October",1990,2,0,1,'approved'),/*VdrsMq2fjZJwnBbZ*/
    ("Mr","John","Quincey","Adams","John@RARegister","User",0123441,"$2y$12$ajccqYfuLWEYaXRqJSlK0eVisc4No1OLBXyMSp8wer9Xpws0YKXiu",12,"October",1990,0,0,1,'approved'),/*RZu66ZEEFaL3Lukx*/
    ("Miss","Libby","","Pellow","Libby@RARegister","User",0123441,"$2y$12$yq8X0FIod9DsSC6fvk9WHew9By8/Z2gtOmylqr6b8wYFXilrCS1Uu",12,"October",1990,0,0,0,'approved'),/*F368Rf4Nk4w7BnGD*/
    ("Mr","Alec","","Baldwin","Alec@RARegister","User",0123441,"$2y$12$GP2hm3I7dQvnlhZk4uz0eOQulT1S09XcaESjEa2Jb4yVTwNegFTOi",12,"October",1990,0,0,1,'approved'),/*jbPE5ZTzUF2DhguK*/
    ("Miss","Christina","","Perri","Perri@RARegister","User",0123441,"$2y$12$WuE6VeLLHfkYYkYRSdokP.pLP1Al.aoSmd5qoiuG.N1y/QjRkA/BC",12,"October",1990,0,0,0,'approved'),/*gzCM4E25XZ5JTx9c*/
    ("Mr","Kevin","Crispy","Bacon","Bacon@RARegister","User",0123441,"$2y$12$gNVi4xbE2DkfYW1gGVvq6eXVyYiXEttf2m5d/qq0nHKR.0U.wJbry",12,"October",1990,0,0,1,'approved'),/*QXpmmu2Gj7Y5aa9h*/
    ("Dr","Root","Root","Root","Root@RARegister","Root",0123441,"$2y$12$TGUAGlTX/T0fFwF2XvPHde70pmNAfmoSNz87r70gpHmOTYlrXAAZG",12,"October",1990,3,0,1,'approved'),/*qTm2e7uvt9QRCCfs*/
    ("Miss","Stacey","","Goodwin","Goodwin@RARegister","User",0123441,"$2y$12$bNbTaLfs9iyau9ZUZaGlau5rAya/FTuDV4deQbOOpm63G9TxD20re",12,"October",1990,0,0,0,'approved');/*ZBguFhLvw94vxxZM*/

CREATE TABLE Qualification
(
    qualification_id INT PRIMARY KEY AUTO_INCREMENT,
    qualification_type VARCHAR(100),
    qualification_name VARCHAR(100) NOT NULL,
    end_date VARCHAR(15),
    finished int

);

CREATE TABLE University
(
    University_id INT PRIMARY KEY AUTO_INCREMENT,
    University_name VARCHAR(100) NOT NULL
);

INSERT INTO University(University_name) VALUES
    ("Federation University Australia"),
    ("Monash University"),
    ("Deakin University"),
    ("University of Melbourne"),
    ("Australian Catholic University"),
     ("University of Sydney");

CREATE TABLE Study
(
    user_id INT,
    qualification_id INT,
    University_id INT,
    PRIMARY KEY(user_id,qualification_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (qualification_id) REFERENCES Qualification(qualification_id),
    FOREIGN KEY (University_id) REFERENCES University(University_id)
);
CREATE TABLE Employment
(
    employment_id INT PRIMARY KEY AUTO_INCREMENT,
    work_rate VARCHAR(50),
    position_title VARCHAR(50),
    manager VARCHAR(50),
    manager_phone VARCHAR(13) NOT NULL,
    organisation VARCHAR(50),
    startDate VARCHAR(50),
    endDate VARCHAR(50),
    tasks VARCHAR(250)

);


CREATE TABLE User_Employment
(  
   user_id INT NOT NULL,
   employment_id INT NOT NULL,
   PRIMARY KEY(employment_id,user_id),
   FOREIGN KEY (user_id) REFERENCES Users(user_id),
   FOREIGN KEY (employment_id) REFERENCES Employment(employment_id)


);
CREATE TABLE Files
(
    file_id INT PRIMARY KEY AUTO_INCREMENT,
    file_name VARCHAR(100) NOT NULL,
    file_location VARCHAR(200) NOT NULL,
    file_size INT NOT NULL
);



CREATE TABLE Skills
(
    skill_id INT PRIMARY KEY AUTO_INCREMENT,
    skill_name VARCHAR(100) NOT NULL,
    skill_type VARCHAR(100)
);



CREATE TABLE User_Skills
(
    user_id INT,
    skill_id INT,
    skill_level VARCHAR(10),
    PRIMARY KEY(user_id,skill_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (skill_id) REFERENCES Skills(skill_id)
);

CREATE TABLE User_Files
(
   file_id INT NOT NULL,
   user_id INT NOT NULL,
   PRIMARY KEY(file_id,user_id),
   FOREIGN KEY (user_id) REFERENCES Users(user_id),
   FOREIGN KEY (file_id) REFERENCES files(file_id)
);

INSERT INTO Skills(skill_name,skill_type) VALUES

    ("Use of normal Microsoft range of programs","General"),
    ("Written English","General"),
    ("Spoken English","General"),
    ("Organising Meetings","General"),
    ("Dealing with external stakeholders","General"),
    ("Managing Work Tasks","General"),
    ("Project Management","General"),

    ("Preparing Ethics Applications","Research"),
    ("Literature Searches","Research"),
    ("Writing Literature Reviews","Research"),
    ("Referencing Skills","Research"),
    ("Contributing to the writing of papers","Research"),
    ("Contributing to the preparation of presentations","Research"),
    ("Contributing to the preparation of reports","Research"),
    ("Assisting with grant applications","Research"),
    ("Maintaining accurate project records","Research"),
    ("Keeping Project Budget Records","Research"),
    ("Taking notes and writing minutes from project meetings","Research"),
    ("Recruiting participants","Research"),
    ("Interviewing face to face","Research"),
    ("Interviewing by phone","Research"),
    ("Survey Design and Development","Research"),
    ("Preparing on-line surveys","Research"),
    ("Data Analysis-Qualitative","Research"),
    ("Data Analysis-Quantitative","Research"),

    ("Systematic Reviews of Literature","Psychology"),
    ("Manuscript Drifting","Psychology"),
    ("Participant Recruitment","Psychology"),
    ("Psychology lab skills","Psychology"),
    ("Therapy Work","Psychology"),
    ("Other","Psychology"),

        ("Java Programming","Information Technology"),
    ("Networking","Information Technology"),
    ("Games Design","Information Technology");




