-- users

CREATE TABLE IF NOT EXISTS users(
    id_user int unsigned NOT NULL AUTO_INCREMENT,
    user_firstname varchar(45) DEFAULT NULL,
    user_lastname varchar(45) DEFAULT NULL,
    user_email varchar(50) DEFAULT NULL,
    user_password varchar(255) DEFAULT NULL,
    user_reg_date date DEFAULT NULL,
    PRIMARY KEY(id_user),
    UNIQUE KEY(user_email)
);

-- incomes

CREATE TABLE IF NOT EXISTS income_user_category(
    id_inc_user_cat int unsigned NOT NULL AUTO_INCREMENT,
    id_user int unsigned NOT NULL,
    inc_cat_name varchar(60) DEFAULT NULL,  
    PRIMARY KEY(id_inc_user_cat),
    FOREIGN KEY(id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS default_income_category(
    id_inc_cat int unsigned NOT NULL AUTO_INCREMENT,
    inc_cat_name varchar(60) DEFAULT NULL,  
    PRIMARY KEY(id_inc_cat)
);

CREATE TABLE IF NOT EXISTS income(
    id_inc int unsigned NOT NULL AUTO_INCREMENT,
    id_user int unsigned NOT NULL,
    inc_date datetime DEFAULT NULL,
    id_inc_cat int unsigned DEFAULT NULL,
    inc_amount decimal(10,2) DEFAULT NULL,
    inc_comment varchar(100) DEFAULT NULL,  
    PRIMARY KEY(id_inc),
    FOREIGN KEY(id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(id_inc_cat) REFERENCES income_user_category(id_inc_user_cat) ON DELETE SET NULL ON UPDATE CASCADE
);



-- expenses

CREATE TABLE IF NOT EXISTS expense_user_category(
    id_exp_user_cat int unsigned NOT NULL AUTO_INCREMENT,
    id_user int unsigned NOT NULL,
    exp_cat_name varchar(60) DEFAULT NULL,  
    PRIMARY KEY(id_exp_user_cat),
    FOREIGN KEY(id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS payment_user_method(
    id_user_pay_met int unsigned NOT NULL AUTO_INCREMENT,
    id_user int unsigned NOT NULL,
    pay_met_name varchar(60) DEFAULT NULL,  
    PRIMARY KEY(id_user_pay_met),
    FOREIGN KEY(id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS default_expense_category(
    id_exp_cat int unsigned NOT NULL AUTO_INCREMENT,
    exp_cat_name varchar(60) DEFAULT NULL,  
    PRIMARY KEY(id_exp_cat)
);

CREATE TABLE IF NOT EXISTS default_payment_method(
    id_pay_met int unsigned NOT NULL AUTO_INCREMENT,
    pay_met_name varchar(60) DEFAULT NULL,  
    PRIMARY KEY(id_pay_met)
);

CREATE TABLE IF NOT EXISTS expense(
    id_exp int unsigned NOT NULL AUTO_INCREMENT,
    id_user int unsigned NOT NULL,
    exp_date datetime DEFAULT NULL,
    id_exp_cat int unsigned DEFAULT NULL,
    exp_amount decimal(10,2) DEFAULT NULL,
    id_pay_met int unsigned DEFAULT NULL,
    exp_comment varchar(100) DEFAULT NULL,  
    PRIMARY KEY(id_exp),
    FOREIGN KEY(id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(id_exp_cat) REFERENCES expense_user_category(id_exp_user_cat) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY(id_pay_met) REFERENCES payment_user_method(id_user_pay_met) ON DELETE SET NULL ON UPDATE CASCADE
);

-- indexes for foreign keys

CREATE INDEX idx_income_user ON income(id_user);
CREATE INDEX idx_income_cat ON income(id_inc_cat);
CREATE INDEX idx_income_user_category_user ON income_user_category(id_user);
CREATE INDEX idx_expense_user ON expense(id_user);
CREATE INDEX idx_expense_cat ON expense(id_exp_cat);
CREATE INDEX idx_expense_pay ON expense(id_pay_met);
CREATE INDEX idx_expense_user_category_user ON expense_user_category(id_user);
CREATE INDEX idx_payment_user_method_user ON payment_user_method(id_user);

-- defaults

INSERT INTO `default_income_category` (`id_inc_cat`, `inc_cat_name`) VALUES
(1, 'Employment contract'),
(2, 'Task contract'),
(3, 'Allegro sales'),
(4, 'Olx sales'),
(5, 'Overtime'),
(6, 'Bank interest'),
(7, 'Bonus');

INSERT INTO `default_expense_category` (`id_exp_cat`, `exp_cat_name`) VALUES
(1, 'Shopping'),
(2, 'Sport'),
(3, 'Bills'),
(4, 'Entertainment'),
(5, 'Gifts'),
(6, 'Cleaning'),
(7, 'Food');

INSERT INTO `default_payment_method` (`id_pay_met`, `pay_met_name`) VALUES
(1, 'Cash'),
(2, 'Debit card'),
(3, 'Credit card'),
(4, 'BLIK'),
(5, 'Bank transfer'),
(6, 'Coupon'),
(7, 'Gift card'),
(8, 'Voucher'),
(9, 'Promo code');


ALTER TABLE `default_expense_category`
  MODIFY `id_exp_cat` int unsigned NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `default_income_category`
  MODIFY `id_inc_cat` int unsigned NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `default_payment_method`
  MODIFY `id_pay_met` int unsigned NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

