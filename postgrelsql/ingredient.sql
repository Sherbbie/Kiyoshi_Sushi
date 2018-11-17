-- Table: public.tblingredient

-- DROP TABLE public.tblingredient;

CREATE TABLE public.tblingredient
(
    ingredient_id character varying(4) NOT NULL,
    ingredient_name character varying(100) NOT NULL,
    CONSTRAINT tblingredient_pkey PRIMARY KEY (ingredient_id),
    CONSTRAINT tblingredient_ingredient_name_key UNIQUE (ingredient_name)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tblingredient
    OWNER to postgres;