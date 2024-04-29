
CREATE TABLE tblAccount (
  accountId BIGINT AUTO_INCREMENT PRIMARY KEY,

  firstName TEXT NOT NULL,
  lastName TEXT NOT NULL,
  email TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  gender ENUM('male', 'female') DEFAULT 'male',
  birthdate DATETIME,

  CONSTRAINT chkGender CHECK (gender IN ('male', 'female'))
);

CREATE TABLE tblUser (
  userId BIGINT,

  street TEXT,
  barangay TEXT,
  municipality TEXT,
  province TEXT,
  country TEXT NOT NULL,
  zipcode TEXT
);

CREATE TABLE tblSeller (
  sellerId BIGINT,

  sellerCertification TEXT
);

CREATE TABLE tblBuyer (
  buyerId BIGINT
);

CREATE TABLE tblProduct (
  productId BIGINT AUTO_INCREMENT PRIMARY KEY,

  sellerId BIGINT,

  productName TEXT,
  description TEXT,
  quantity BIGINT,
  price DOUBLE
);

CREATE TABLE tblCart (
  cartId BIGINT AUTO_INCREMENT PRIMARY KEY,

  userId BIGINT
);

CREATE TABLE tblCartItem (
  cartId BIGINT,
  productId BIGINT
);

CREATE TABLE tblOrder (
  orderId BIGINT AUTO_INCREMENT PRIMARY KEY,

  buyerId BIGINT,

  isPaid BOOLEAN DEFAULT FALSE
);

CREATE TABLE tblOrderItem (
  orderId BIGINT,

  productId BIGINT,

  quantity BIGINT
);

CREATE TABLE tblPayment (
  paymentId BIGINT AUTO_INCREMENT PRIMARY KEY,

  orderId BIGINT,
  buyerId BIGINT,

  amount BIGINT,
  date DATETIME DEFAULT NOW()
);

CREATE TABLE tblReview (
  reviewId BIGINT AUTO_INCREMENT PRIMARY KEY,

  userId BIGINT,

  rating INT(5),
  message TEXT
);

CREATE TABLE tblReply (
  replyId BIGINT AUTO_INCREMENT PRIMARY KEY,

  reviewId BIGINT,

  message TEXT
);

ALTER TABLE tblUser
ADD CONSTRAINT fkUserAccount
FOREIGN KEY (userId) REFERENCES tblAccount(accountId)
ON DELETE CASCADE;

ALTER TABLE tblSeller
ADD CONSTRAINT fkSellerAccount
FOREIGN KEY (sellerId) REFERENCES tblAccount(accountId)
ON DELETE CASCADE;

ALTER TABLE tblBuyer
ADD CONSTRAINT fkBuyerAccount
FOREIGN KEY (buyerId) REFERENCES tblAccount(accountId)
ON DELETE CASCADE;

ALTER TABLE tblProduct
ADD CONSTRAINT fkProductSeller
FOREIGN KEY (sellerId) REFERENCES tblSeller(sellerId)
ON DELETE CASCADE;

ALTER TABLE tblCart
ADD CONSTRAINT fkCartUser
FOREIGN KEY (userId) REFERENCES tblUser(userId)
ON DELETE CASCADE;

ALTER TABLE tblCartItem
ADD CONSTRAINT fkCartItemCart
FOREIGN KEY (cartId) REFERENCES tblCart(cartId)
ON DELETE CASCADE,
ADD CONSTRAINT fkCartItemProduct
FOREIGN KEY (productId) REFERENCES tblProduct(productId)
ON DELETE CASCADE;

ALTER TABLE tblOrder
ADD CONSTRAINT fkOrderBuyer
FOREIGN KEY (buyerId) REFERENCES tblBuyer(buyerId)
ON DELETE CASCADE;

ALTER TABLE tblOrderItem
ADD CONSTRAINT fkOrderItemOrder
FOREIGN KEY (orderId) REFERENCES tblOrder(orderId)
ON DELETE CASCADE,
ADD CONSTRAINT fkOrderItemProduct
FOREIGN KEY (productId) REFERENCES tblProduct(productId)
ON DELETE CASCADE;

ALTER TABLE tblPayment
ADD CONSTRAINT fkPaymentOrder
FOREIGN KEY (orderId) REFERENCES tblOrder(orderId)
ON DELETE CASCADE,
ADD CONSTRAINT fkPaymentBuyer
FOREIGN KEY (buyerId) REFERENCES tblBuyer(buyerId)
ON DELETE CASCADE;

ALTER TABLE tblReview
ADD CONSTRAINT fkReviewUser
FOREIGN KEY (userId) REFERENCES tblUser(userId)
ON DELETE CASCADE;

ALTER TABLE tblReply
ADD CONSTRAINT fkReplyReview
FOREIGN KEY (reviewId) REFERENCES tblReview(reviewId)
ON DELETE CASCADE;
