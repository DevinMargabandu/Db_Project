CREATE TABLE Student (
    StudentID INT PRIMARY KEY,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    Email VARCHAR(100),
    Major VARCHAR(50),
    GradYear INT
);

CREATE TABLE Club (
    ClubID INT PRIMARY KEY,
    ClubName VARCHAR(100),
    ContactInfo VARCHAR(100),
    PresidentID INT,
    Field VARCHAR(50),
    FOREIGN KEY (PresidentID) REFERENCES Student(StudentID)
);

CREATE TABLE Event (
    EventID INT PRIMARY KEY,
    EventName VARCHAR(100),
    EventDate DATE,
    Location VARCHAR(100),
    Description TEXT,
    Capacity INT,
    ClubID INT,
    FOREIGN KEY (ClubID) REFERENCES Club(ClubID)
);

CREATE TABLE Registration (
    StudentId INT,
    EventID INT,
    RegistrationDate DATE,
    AttendanceStatus VARCHAR(50),
    PRIMARY KEY (StudentId, EventID),
    FOREIGN KEY (StudentId) REFERENCES Student(StudentID),
    FOREIGN KEY (EventID) REFERENCES Event(EventID)
);
