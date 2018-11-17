-- Table: public.tblitemingredient

-- DROP TABLE public.tblitemingredient;

CREATE TABLE public.tblitemingredient
(
    ingredient_id character varying(4)NOT NULL,
    product_id character varying(4)NOT NULL,
    amount numeric,
    unit_measurement character varying(20) COLLATE "default".pg_catalog,
    CONSTRAINT tblitemingredient_pkey PRIMARY KEY (ingredient_id, product_id),
    CONSTRAINT fk_ingredient FOREIGN KEY (ingredient_id)
        REFERENCES public.tblingredient (ingredient_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT fk_product FOREIGN KEY (product_id)
        REFERENCES public.tblproducts (product_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tblitemingredient
    OWNER to postgres;