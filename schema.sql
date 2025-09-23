CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100),
    surname VARCHAR(100) NOT NULL,
    date_of_birth DATE NOT NULL,
    document_serial VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    coc_file VARCHAR(255) NOT NULL,
    cop_file VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    certificate_id VARCHAR(100) NOT NULL,
    certificate_type VARCHAR(100) NOT NULL,
    policy_text TEXT,

    title_one_id INT NOT NULL,
    title_two_id INT NOT NULL,
    title_three_id INT NOT NULL,

    profile_photo VARCHAR(255),
    signature_photo VARCHAR(255),
    full_name VARCHAR(255) NOT NULL,
    date_of_birth DATE,
    certificate_number VARCHAR(255) UNIQUE,
    nationality VARCHAR(100),
    date_of_issue DATE,
    date_of_expiry DATE,
    place_of_issue VARCHAR(255),
    registry_seal_img VARCHAR(255),
    authority_signature_img VARCHAR(255),
    title VARCHAR(255),                            
    name VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE titles_one (
    id INT AUTO_INCREMENT PRIMARY KEY,
    certificate_id INT NOT NULL,
    title_of_training VARCHAR(255),
    stcw_regulation VARCHAR(255),
    section_stcw_code VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (certificate_id) REFERENCES certificates(id) ON DELETE CASCADE
);

CREATE TABLE titles_two (
    id INT AUTO_INCREMENT PRIMARY KEY,
    certificate_id INT NOT NULL,
    functions VARCHAR(255),
    levels VARCHAR(255),
    limitations VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (certificate_id) REFERENCES certificates(id) ON DELETE CASCADE
);

CREATE TABLE titles_three (
    id INT AUTO_INCREMENT PRIMARY KEY,
    certificate_id INT NOT NULL,
    capacity VARCHAR(255),
    stcw_regulation VARCHAR(255),
    limitations VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (certificate_id) REFERENCES certificates(id) ON DELETE CASCADE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL
);