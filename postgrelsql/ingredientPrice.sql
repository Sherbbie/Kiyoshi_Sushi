-- Table: public.tblingredientprice

-- DROP TABLE public.tblingredientprice;

CREATE TABLE public.tblingredientprice
(
    ingredient_id character varying(4) NOT NULL,
    date_time_added timestamp without time zone NOT NULL,
    supplier_id character varying(4) NOT NULL,
    market_price numeric NOT NULL,
    CONSTRAINT tblingredientprice_pkey PRIMARY KEY (ingredient_id, date_time_added, supplier_id),
    CONSTRAINT fkey_ingredient FOREIGN KEY (ingredient_id)
        REFERENCES public.tblingredient (ingredient_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT fkey_supplier FOREIGN KEY (supplier_id)
        REFERENCES public.tblsupplier (supplier_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tblingredientprice
    OWNER to postgres;