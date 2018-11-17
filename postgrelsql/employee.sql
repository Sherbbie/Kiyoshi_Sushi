-- Table: public.tblemployee

-- DROP TABLE public.tblemployee;

CREATE TABLE public.tblemployee
(
    user_id character varying(14) NOT NULL,
    "position" character varying(20) NOT NULL,
    sin_number character varying(9) NOT NULL,
    annual_salary money NOT NULL,
    start_date date NOT NULL,
    end_date date,
    admin_privileges boolean NOT NULL,
    CONSTRAINT tblemployee_pkey PRIMARY KEY (user_id),
    CONSTRAINT tblemployee_user_id_fkey FOREIGN KEY (user_id)
        REFERENCES public.tblusers (user_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tblemployee
    OWNER to postgres;