create database blood;
use blood;
create table admin(
    email varchar(255),
    password varchar(255),
    primary key(email)
);

insert into admin(email,password) values ('admin@gmail.com','admin123');

create table users(
    email varchar(255),
    name varchar(255),
    bloodGroup varchar(5),
    phone varchar(13),
    address varchar(255),
    gender varchar(10),
    occupation varchar(255),
    chatId BIGINT,
    image varchar(100), 
    password varchar(255),
    primary key(email)
);
insert into users(email,name,bloodGroup,phone,address,gender,occupation,chatId,image,password) 
values ('user1@gmail.com','user1','A+','01234567890','','male', 'student', '991', '','3b712de48137572f3849aabd5666a4e3'),
('user2@gmail.com','user2','B+','01234567890','','male', 'student', '992', '','3b712de48137572f3849aabd5666a4e3'),
('user3@gmail.com','user3','AB+','01234567890','','male', 'student', '993', '','3b712de48137572f3849aabd5666a4e3'),
('user4@gmail.com','user4','O+','01234567890','','male', 'student', '994', '','3b712de48137572f3849aabd5666a4e3'),
('user5@gmail.com','user5','A-','01234567890','','male', 'student', '995', '','3b712de48137572f3849aabd5666a4e3'),
('user6@gmail.com','user6','B-','01234567890','','male', 'student', '996', '','3b712de48137572f3849aabd5666a4e3'),
('user7@gmail.com','user7','AB-','01234567890','','male', 'student', '997', '','3b712de48137572f3849aabd5666a4e3'),
('user8@gmail.com','user8','O-','01234567890','','male', 'student', '998', '','3b712de48137572f3849aabd5666a4e3');

create table bloodbank(
    id INT AUTO_INCREMENT,
    email varchar(255),
    last_donated date,
    name varchar(255),
    bloodGroup varchar(5),
    status varchar(1),
    primary key(id),
    constraint fk_email_bloodbank foreign key(email) references users(email) on delete cascade on update cascade
);

insert into bloodbank(email,last_donated,name,bloodGroup,status) 
values ('user1@gmail.com','2020-01-01','user1','A+','1'),
('user2@gmail.com','2020-01-02','user2','B+','1'),
('user3@gmail.com','2020-01-03','user3','AB+','1'),
('user4@gmail.com','2020-01-04','user4','O+','1'),
('user5@gmail.com','2020-01-05','user5','A-','1'),
('user6@gmail.com','2020-01-06','user6','B-','1'),
('user7@gmail.com','2020-01-07','user7','AB-','1'),
('user8@gmail.com','2020-01-08','user8','O-','1');

create table request(
    id int auto_increment,
    email varchar(255),
    bloodGroup varchar(5),
    quantity varchar(50),
    request_date date,
    status varchar(1),
    primary key(id),
    constraint fk_email_request foreign key(email) references users(email) on delete cascade on update cascade
);

insert into request(email,bloodGroup,quantity,request_date,status)
values ('user1@gmail.com','A+','1','2020-01-01','1'),
('user2@gmail.com','B+','1','2020-01-02','1'),
('user3@gmail.com','AB+','1','2020-01-03','1'),
('user4@gmail.com','O+','1','2020-01-04','1'),
('user5@gmail.com','A-','1','2020-01-05','1'),
('user6@gmail.com','B-','1','2020-01-06','1'),
('user7@gmail.com','AB-','1','2020-01-07','1'),
('user8@gmail.com','O-','1','2020-01-08','1');

-- admin activiy
--1. manage all user
--2. manage all blood bank
--3. manage all request
--4. add new user
--5. dashboard

weight
hight
dob
