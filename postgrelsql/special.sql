-- Table: public.tblspecials

-- DROP TABLE public.tblspecials;

CREATE TABLE public.tblspecials
(
    discount_id character varying(30) NOT NULL,
    user_id character varying NOT NULL,
    datetime_assigned date,
    CONSTRAINT tblspecials_pkey PRIMARY KEY (discount_id, user_id),
    CONSTRAINT fk_discount FOREIGN KEY (discount_id)
        REFERENCES public.tbldiscount (discount_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT fk_user FOREIGN KEY (user_id)
        REFERENCES public.tblusers (user_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tblspecials
    OWNER to postgres;