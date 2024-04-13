
CREATE TABLE tblAccount (
  account_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  firstname TEXT NOT NULL,
  lastname TEXT NOT NULL,

  email TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,

  gender ENUM('male', 'female') DEFAULT 'male',
  birthdate DATETIME,

  CONSTRAINT CHK_Gender CHECK (gender IN ('male', 'female'))
};

CREATE TABLE tblUser (
  user_id BIGINT,
  
  street TEXT,
  barangay TEXT,
  municipality TEXT,
  province TEXT,
  country TEXT NOT NULL,
  zipcode TEXT
);

CREATE TABLE tblSeller (
  seller_id BIGINT,
  
  seller_certification TEXT
);

CREATE TABLE tblBuyer (
  buyer_id BIGINT
);

CREATE TABLE tblProduct (
  product_id BIGINT AUTO_INCREMENT PRIMARY_KEY,

  seller_id BIGINT,

  product_name TEXT,
  description TEXT,
  quantity BIGINT,
  price DOUBLE,
);


CREATE TABLE tblCart (
  cart_id BIGINT AUTO_INCREMENT PRIMARY_KEY,

  user_id BIGINT,
);


CREATE TABLE tblCartItem (
  cart_id BIGINT,
  product_id BIGINT,
);

CREATE TABLE tblOrder (
  order_id BIGINT AUTO_INCREMENT PRIMARY_KEY,

);

CREATE TABLE tblOrderItem (

  order_id BIGINT,
  product_id BIGINT,

  quantity BIGINT,
);

CREATE TABLE tblPayment (
  payment_id BIGINT AUTO_INCREMENT PRIMARY_KEY,

  order_id BIGINT,
  buyer_id BIGINT,

  amount BIGINT,
  date DATETIME DEFAULT NOW(),
);

CREATE TABLE tblReview (
  reply_id BIGINT AUTO_INCREMENT PRIMARY_KEY,

  user_id BIGINT,

  rating INT(5),
  message TEXT,
);


CREATE TABLE tblReply (
  reply_id BIGINT,

  message TEXT,
);




ALTER TABLE `tblAccount`
  ADD CONSTRAINT `tbluser_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tblAccount` (`account_id`);
COMMIT;

ALTER TABLE `tblAccount`
  ADD CONSTRAINT `tblbuyer_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `tblAccount` (`account_id`);
COMMIT;

ALTER TABLE `tblAccount`
  ADD CONSTRAINT `tblseller_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `tblAccount` (`account_id`);
COMMIT;

ALTER TABLE `tblProduct`
  ADD CONSTRAINT `tblseller_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `tblProduct` (`seller_id`);
COMMIT;




