-- Table: public.tblorderlineitem

-- DROP TABLE public.tblorderlineitem;

CREATE TABLE public.tblorderlineitem
(
    order_id character varying(7) NOT NULL,
    product_id character varying(4) NOT NULL,
    quantity integer,
    CONSTRAINT tblorderlineitem_pkey PRIMARY KEY (order_id, product_id),
    CONSTRAINT fk_order FOREIGN KEY (order_id)
        REFERENCES public.tblorder (order_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT fk_products FOREIGN KEY (product_id)
        REFERENCES public.tblproducts (product_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tblorderlineitem
    OWNER to postgres;