CREATE TABLE system_logs
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NULL,
    user_name   VARCHAR(150) NULL,
    action      VARCHAR(100) NOT NULL,
    description TEXT NULL,
    ip_address  VARCHAR(45) NULL,
    user_agent  TEXT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);