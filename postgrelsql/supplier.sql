-- Table: public.tblsupplier

-- DROP TABLE public.tblsupplier;

CREATE TABLE public.tblsupplier
(
    supplier_id character varying(4) NOT NULL,
    first_name character varying(80) NOT NULL,
    last_name character varying(100) NOT NULL,
    email character varying(250) NOT NULL,
    phone_number character varying(12) NOT NULL,
    CONSTRAINT tblsupplier_pkey PRIMARY KEY (supplier_id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tblsupplier
    OWNER to postgres;