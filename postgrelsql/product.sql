-- Table: public.tblproducts

-- DROP TABLE public.tblproducts;

CREATE TABLE public.tblproducts
(
    product_id character varying(30) NOT NULL,
    name character varying(100),
    price numeric,
    description character varying(100),
    on_menu boolean,
    type character varying(100),
    CONSTRAINT tblproducts_pkey PRIMARY KEY (product_id),
    CONSTRAINT tblproducts_name_key UNIQUE (name)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tblproducts
    OWNER to postgres;