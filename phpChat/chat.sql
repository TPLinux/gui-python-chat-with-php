CREATE TABLE msgs(
    msg_id int AUTO_INCREMENT PRIMARY KEY,
    msg_content text,
    msg_from varchar(25),
    msg_to varchar(25),
    msg_date timestamp not null DEFAULT CURRENT_TIMESTAMP
)ENGINE=MyIsam DEFAULT charset utf8;
    

CREATE TABLE chat_u(
    u_id int AUTO_INCREMENT PRIMARY KEY,
    u_name varchar(25),
    u_pass varchar(40)
)ENGINE=MyIsam DEFAULT charset utf8;
    
