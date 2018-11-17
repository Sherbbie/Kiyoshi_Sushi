-- Table: public.tbldiscountlineitem

-- DROP TABLE public.tbldiscountlineitem;

CREATE TABLE public.tbldiscountlineitem
(
    order_id character varying(7) NOT NULL,
    discount_id character varying(4) NOT NULL,
    CONSTRAINT tbldiscountlineitem_pkey PRIMARY KEY (discount_id, order_id),
    CONSTRAINT fk_discount FOREIGN KEY (discount_id)
        REFERENCES public.tbldiscount (discount_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT fk_order FOREIGN KEY (order_id)
        REFERENCES public.tblorder (order_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tbldiscountlineitem
    OWNER to postgres;