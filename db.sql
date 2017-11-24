create table student(
studentno int auto_increment primary key,
studentname nvarchar(32));

create table teacher(
teacherno int auto_increment primary key,
teachername nvarchar(32),
username varchar(20),
password varchar(20));


create table course(
teacherno int REFERENCES teacher(teacherno),
coursename nvarchar(32),
courseno int primary key);


create table score(
courseno int references course(couseno),
studentno int references student(studentno),
pregrade float,
lastgrade float,
totalgrade float);

create table admin(
username varchar(32),
password varchar(32)
);
