
CREATE TABLE tblAccount (
  account_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  firstname TEXT NOT NULL,
  lastname TEXT NOT NULL,
  email TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  gender ENUM('male', 'female') DEFAULT 'male',
  birthdate DATETIME,

  CONSTRAINT CHK_Gender CHECK (gender IN ('male', 'female'))
);

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
  product_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  seller_id BIGINT,

  product_name TEXT,
  description TEXT,
  quantity BIGINT,
  price DOUBLE
);

CREATE TABLE tblCart (
  cart_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  user_id BIGINT
);

CREATE TABLE tblCartItem (
  cart_id BIGINT,
  product_id BIGINT
);

CREATE TABLE tblOrder (
  order_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  buyer_id BIGINT
);

CREATE TABLE tblOrderItem (
  order_id BIGINT,

  product_id BIGINT,

  quantity BIGINT
);

CREATE TABLE tblPayment (
  payment_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  order_id BIGINT,
  buyer_id BIGINT,

  amount BIGINT,
  date DATETIME DEFAULT NOW()
);

CREATE TABLE tblReview (
  review_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  user_id BIGINT,

  rating INT(5),
  message TEXT
);

CREATE TABLE tblReply (
  reply_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  review_id BIGINT,

  message TEXT
);

ALTER TABLE tblUser
ADD CONSTRAINT FK_User_Account
FOREIGN KEY (user_id) REFERENCES tblAccount(account_id);

ALTER TABLE tblSeller
ADD CONSTRAINT FK_Seller_Account
FOREIGN KEY (seller_id) REFERENCES tblAccount(account_id);

ALTER TABLE tblBuyer
ADD CONSTRAINT FK_Buyer_Account
FOREIGN KEY (buyer_id) REFERENCES tblAccount(account_id);

ALTER TABLE tblProduct
ADD CONSTRAINT FK_Product_Seller
FOREIGN KEY (seller_id) REFERENCES tblSeller(seller_id);

ALTER TABLE tblCart
ADD CONSTRAINT FK_Cart_User
FOREIGN KEY (user_id) REFERENCES tblUser(user_id);

ALTER TABLE tblCartItem
ADD CONSTRAINT FK_CartItem_Cart
FOREIGN KEY (cart_id) REFERENCES tblCart(cart_id),
ADD CONSTRAINT FK_CartItem_Product
FOREIGN KEY (product_id) REFERENCES tblProduct(product_id);

ALTER TABLE tblOrder
ADD CONSTRAINT FK_Order_Buyer
FOREIGN KEY (buyer_id) REFERENCES tblBuyer(buyer_id);

ALTER TABLE tblOrderItem
ADD CONSTRAINT FK_OrderItem_Order
FOREIGN KEY (order_id) REFERENCES tblOrder(order_id),
ADD CONSTRAINT FK_OrderItem_Product
FOREIGN KEY (product_id) REFERENCES tblProduct(product_id);

ALTER TABLE tblPayment
ADD CONSTRAINT FK_Payment_Order
FOREIGN KEY (order_id) REFERENCES tblOrder(order_id),
ADD CONSTRAINT FK_Payment_Buyer
FOREIGN KEY (buyer_id) REFERENCES tblBuyer(buyer_id);

ALTER TABLE tblReview
ADD CONSTRAINT FK_Review_User
FOREIGN KEY (user_id) REFERENCES tblUser(user_id);

ALTER TABLE tblReply
ADD CONSTRAINT FK_Reply_Review
FOREIGN KEY (review_id) REFERENCES tblReview(review_id);
