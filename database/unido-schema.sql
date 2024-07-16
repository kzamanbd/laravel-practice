CREATE TABLE UNIDO_SALES_INVOICE_HEADER (
    invoice_number    VARCHAR(100),
    customer_po       VARCHAR(100),
    invoice_date      VARCHAR(100),
    customer_code     VARCHAR(100),
    wh_code           VARCHAR(100),
    inv_pay_term      VARCHAR(100),
    net_sales         DECIMAL(10, 2),
    inv_tax           DECIMAL(10, 2),
    inv_discount      DECIMAL(10, 2),
    dist_ref_id       VARCHAR(100),
    status            INT,
    processed         INT DEFAULT 0
);

CREATE TABLE UNIDO_SALES_INVOICE_LINES (
    invoice_number    VARCHAR(100),
    customer_po       VARCHAR(100),
    inv_line          VARCHAR(100),
    invoice_date      VARCHAR(100),
    mkt_code          VARCHAR(30),
    lot_no            VARCHAR(30),
    busi_division     VARCHAR(30),
    line_typev        VARCHAR(30),
    qty_req           DECIMAL(10, 2),
    trans_qty         DECIMAL(10, 2),
    list_price        DECIMAL(10, 2),
    inv_line_value    DECIMAL(10, 2),
    tot_discount      DECIMAL(10, 2),
    ind_item_tax      DECIMAL(10, 2),
    approval_no       VARCHAR(30),
    dist_ref_id       VARCHAR(100),
    status            INT,
    processed         INT DEFAULT 0
);

CREATE TABLE UNIDO_SALES_RETURN_HEADER (
    invoice_number    VARCHAR(100),
    customer_po       VARCHAR(100),
    invoice_date      VARCHAR(100),
    cr_ref_invoice    VARCHAR(100),
    ref_iv_date       VARCHAR(30),
    customer_code     VARCHAR(100),
    wh_code           VARCHAR(100),
    inv_pay_term      VARCHAR(100),
    net_sales         DECIMAL(10, 2),
    inv_tax           DECIMAL(10, 2),
    inv_discount      DECIMAL(10, 2),
    cr_memo_reason    VARCHAR(100),
    dist_ref_id       INT,
    status            INT,
    processed         INT DEFAULT 0
);

CREATE TABLE UNIDO_SALES_RETURN_LINES (
    return_no       VARCHAR(30),
    cust_po_no      VARCHAR(100),
    return_line_no  VARCHAR(30),
    return_date     VARCHAR(100),
    cr_ref_inv      VARCHAR(100),
    ref_inv_date    VARCHAR(30),
    item_code       VARCHAR(30),
    batch_lot       VARCHAR(30),
    busi_div        VARCHAR(100),
    line_type       VARCHAR(100),
    ret_qty         DECIMAL(10, 2),
    list_price      DECIMAL(10, 2),
    inv_line_value  DECIMAL(10, 2),
    ret_discount    DECIMAL(10, 2),
    ret_vat         DECIMAL(10, 2),
    dist_ref_id     VARCHAR(100),
    status          INT,
    processed       INT DEFAULT 0
);

CREATE TABLE UNIDO_INV_COLLECTION (
    wh_code         INT,
    cust_code       VARCHAR(30),
    inv_number      INT,
    inv_value       DECIMAL(10, 2),
    pay_date        VARCHAR(30),
    received_aMT    DECIMAL(10, 2),
    pay_rcv_daTE    VARCHAR(30),
    payment_tyPE    VARCHAR(10),
    journal_coDE    VARCHAR(30),
    cust_po         VARCHAR(30),
    status          INT,
    processed       INT DEFAULT 0
);
