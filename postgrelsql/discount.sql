-- Table: public.tbldiscount

-- DROP TABLE public.tbldiscount;

CREATE TABLE public.tbldiscount
(
    discount_id character varying(30)  NOT NULL,
    product_id character varying ,
    percentage numeric,
    dollars numeric,
    start_date date NOT NULL,
    end_date date,
    CONSTRAINT tbldiscount_pkey PRIMARY KEY (discount_id),
    CONSTRAINT product FOREIGN KEY (product_id)
        REFERENCES public.tblproducts (product_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tbldiscount
    OWNER to postgres;