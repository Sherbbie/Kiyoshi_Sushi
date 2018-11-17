-- Table: public.tblusers

-- DROP TABLE public.tblusers;

CREATE TABLE public.tblusers
(
    user_id character varying(14) NOT NULL,
    street_address character varying(70) NOT NULL,
    password character varying(100) NOT NULL,
    last_name character varying(80) NOT NULL,
    first_name character varying(100) NOT NULL,
    email character varying(200) NOT NULL,
    city character varying(70) NOT NULL,
    postal_code character varying(7) NOT NULL,
    province character varying(30) NOT NULL,
    disable_user boolean NOT NULL DEFAULT false,
    phone_number character varying COLLATE "default".pg_catalog,
    CONSTRAINT tblusers_pkey PRIMARY KEY (user_id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tblusers
    OWNER to postgres;