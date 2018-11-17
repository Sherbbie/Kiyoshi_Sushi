-- Table: public.tblorder

-- DROP TABLE public.tblorder;

CREATE TABLE public.tblorder
(
    order_id character varying(7)  NOT NULL,
    user_id character varying(14),
    taxes money,
    order_made_datetime date,
    order_completed_datetime date,
    payment_method character varying(100),
    CONSTRAINT tblorder_pkey PRIMARY KEY (order_id),
    CONSTRAINT tblorder_user_id_fkey FOREIGN KEY (user_id)
        REFERENCES public.tblusers (user_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tblorder
    OWNER to postgres;