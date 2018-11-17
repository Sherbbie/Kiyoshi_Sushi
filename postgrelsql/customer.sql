-- Table: public.tblcustomers

-- DROP TABLE public.tblcustomers;

CREATE TABLE public.tblcustomers
(
    user_id character varying(14) NOT NULL,
    billing_street_address character varying(70) NOT NULL,
    billing_city character varying(60) NOT NULL,
    billing_postal_code character varying(7) NOT NULL,
    billing_province character varying(30) NOT NULL,
    credit_card_number character varying(19),
    cvv character varying(3),
    CONSTRAINT tblcustomers_pkey PRIMARY KEY (user_id),
    CONSTRAINT tblcustomers_user_id_fkey FOREIGN KEY (user_id)
        REFERENCES public.tblusers (user_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tblcustomers
    OWNER to postgres;