-- Create all required databases for SKJ School System

-- Main database (already created by docker-compose)
-- CREATE DATABASE IF NOT EXISTS skjacth_skj;

-- Personnel database
CREATE DATABASE IF NOT EXISTS skjacth_personnel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Academic database  
CREATE DATABASE IF NOT EXISTS skjacth_academic CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Grant permissions
GRANT ALL PRIVILEGES ON skjacth_skj.* TO 'root'@'%';
GRANT ALL PRIVILEGES ON skjacth_personnel.* TO 'root'@'%';
GRANT ALL PRIVILEGES ON skjacth_academic.* TO 'root'@'%';
FLUSH PRIVILEGES;
