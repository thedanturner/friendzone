CREATE DATABASE friendzone;


CREATE TABLE users (
    id int IDENTITY(1,1) PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    mobile VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
)

CREATE TABLE posts (
    id int IDENTITY(1,1) PRIMARY KEY,
    user_id INT NOT NULL,
    body TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
)

CREATE TABLE comments (
    id int IDENTITY(1,1) PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    comment TEXT NOT NULL,
    );
)

CREATE TABLE friends (
    id int IDENTITY(1,1) PRIMARY KEY,
    user_id INT NOT NULL,
    friend_id INT NOT NULL,
    );
)

CREATE TABLE friend_requests (
    id int IDENTITY(1,1) PRIMARY KEY,
    user_id INT NOT NULL,
    friend_id INT NOT NULL,   
    );
)