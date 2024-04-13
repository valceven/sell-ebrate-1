
-- Insert dummy data into tblAccount
INSERT INTO tblAccount (firstname, lastname, email, password, gender, birthdate) VALUES
('John', 'Doe', 'johndoe@example.com', 'password1', 'male', '1990-01-01'),
('Jane', 'Doe', 'janedoe@example.com', 'password2', 'female', '1995-05-15'),
('Mike', 'Smith', 'mikesmith@example.com', 'password3', 'male', '1985-10-20');

-- Insert dummy data into tblUser
INSERT INTO tblUser (user_id, street, barangay, municipality, province, country, zipcode) VALUES
(1, '123 Street', 'Barangay A', 'City A', 'Province A', 'Country A', '12345'),
(2, '456 Street', 'Barangay B', 'City B', 'Province B', 'Country B', '67890');

-- Insert dummy data into tblSeller
INSERT INTO tblSeller (seller_id, seller_certification) VALUES
(1, 'Certification A'),
(2, 'Certification B');

-- Insert dummy data into tblBuyer
INSERT INTO tblBuyer (buyer_id) VALUES
(1),
(2);

-- Insert dummy data into tblProduct
INSERT INTO tblProduct (seller_id, product_name, description, quantity, price) VALUES
(1, 'Product A', 'Description of Product A', 100, 50.99),
(2, 'Product B', 'Description of Product B', 75, 75.50);

-- Insert dummy data into tblCart
INSERT INTO tblCart (user_id) VALUES
(1),
(2);

-- Insert dummy data into tblCartItem
INSERT INTO tblCartItem (cart_id, product_id) VALUES
(1, 1),
(1, 2),
(2, 2);

-- Insert dummy data into tblOrder
INSERT INTO tblOrder () VALUES
(),
();

-- Insert dummy data into tblOrderItem
INSERT INTO tblOrderItem (order_id, product_id, quantity) VALUES
(1, 1, 2),
(2, 2, 1);

-- Insert dummy data into tblPayment
INSERT INTO tblPayment (order_id, buyer_id, amount) VALUES
(1, 1, 101.98),
(2, 2, 75.50);

-- Insert dummy data into tblReview
INSERT INTO tblReview (user_id, rating, message) VALUES
(1, 5, 'Great product!'),
(2, 4, 'Good service.');

-- Insert dummy data into tblReply
INSERT INTO tblReply (reply_id, review_id, message) VALUES
(1, 1, 'Thank you for your feedback.'),
(2, 2, 'We appreciate your review.');
