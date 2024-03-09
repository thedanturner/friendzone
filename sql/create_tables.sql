CREATE DATABASE friendzone;


CREATE TABLE users (
    id int IDENTITY(1,1) PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    status VARCHAR(255) NOT NULL,
    profile_image_url VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    mobile VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    );
)

CREATE TABLE posts (
    id int IDENTITY(1,1) PRIMARY KEY,
    user_id INT NOT NULL,
    content VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
)

CREATE TABLE comments (
    id int IDENTITY(1,1) PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    comment TEXT NOT NULL,
    comment_date DATETIME DEFAULT CURRENT_TIMESTAMP
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