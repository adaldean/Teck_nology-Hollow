--
-- PostgreSQL database dump
--

-- Dumped from database version 16.9 (Ubuntu 16.9-0ubuntu0.24.04.1)
-- Dumped by pg_dump version 16.9 (Ubuntu 16.9-0ubuntu0.24.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: categoria; Type: TABLE; Schema: public; Owner: admin
--

CREATE TABLE public.categoria (
    id_categoria integer NOT NULL,
    nombre character varying(100) NOT NULL
);


ALTER TABLE public.categoria OWNER TO admin;

--
-- Name: categoria_id_categoria_seq; Type: SEQUENCE; Schema: public; Owner: admin
--

CREATE SEQUENCE public.categoria_id_categoria_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categoria_id_categoria_seq OWNER TO admin;

--
-- Name: categoria_id_categoria_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: admin
--

ALTER SEQUENCE public.categoria_id_categoria_seq OWNED BY public.categoria.id_categoria;


--
-- Name: cliente; Type: TABLE; Schema: public; Owner: admin
--

CREATE TABLE public.cliente (
    id_cliente integer NOT NULL,
    nombre character varying(100),
    email character varying(100),
    telefono character varying(20),
    direccion text
);


ALTER TABLE public.cliente OWNER TO admin;

--
-- Name: cliente_id_cliente_seq; Type: SEQUENCE; Schema: public; Owner: admin
--

CREATE SEQUENCE public.cliente_id_cliente_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cliente_id_cliente_seq OWNER TO admin;

--
-- Name: cliente_id_cliente_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: admin
--

ALTER SEQUENCE public.cliente_id_cliente_seq OWNED BY public.cliente.id_cliente;


--
-- Name: detalle_pedido; Type: TABLE; Schema: public; Owner: admin
--

CREATE TABLE public.detalle_pedido (
    id_detalle integer NOT NULL,
    id_pedido integer,
    id_producto integer,
    cantidad integer NOT NULL,
    subtotal numeric(10,2)
);


ALTER TABLE public.detalle_pedido OWNER TO admin;

--
-- Name: detalle_pedido_id_detalle_seq; Type: SEQUENCE; Schema: public; Owner: admin
--

CREATE SEQUENCE public.detalle_pedido_id_detalle_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.detalle_pedido_id_detalle_seq OWNER TO admin;

--
-- Name: detalle_pedido_id_detalle_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: admin
--

ALTER SEQUENCE public.detalle_pedido_id_detalle_seq OWNED BY public.detalle_pedido.id_detalle;


--
-- Name: detalle_venta_pos; Type: TABLE; Schema: public; Owner: admin
--

CREATE TABLE public.detalle_venta_pos (
    id_detalle integer NOT NULL,
    id_venta integer,
    id_producto integer,
    cantidad integer,
    subtotal numeric(10,2)
);


ALTER TABLE public.detalle_venta_pos OWNER TO admin;

--
-- Name: detalle_venta_pos_id_detalle_seq; Type: SEQUENCE; Schema: public; Owner: admin
--

CREATE SEQUENCE public.detalle_venta_pos_id_detalle_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.detalle_venta_pos_id_detalle_seq OWNER TO admin;

--
-- Name: detalle_venta_pos_id_detalle_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: admin
--

ALTER SEQUENCE public.detalle_venta_pos_id_detalle_seq OWNED BY public.detalle_venta_pos.id_detalle;


--
-- Name: empleado; Type: TABLE; Schema: public; Owner: admin
--

CREATE TABLE public.empleado (
    id_empleado integer NOT NULL,
    nombre character varying(100),
    cargo character varying(50),
    email character varying(100),
    id_tienda integer
);


ALTER TABLE public.empleado OWNER TO admin;

--
-- Name: empleado_id_empleado_seq; Type: SEQUENCE; Schema: public; Owner: admin
--

CREATE SEQUENCE public.empleado_id_empleado_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.empleado_id_empleado_seq OWNER TO admin;

--
-- Name: empleado_id_empleado_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: admin
--

ALTER SEQUENCE public.empleado_id_empleado_seq OWNED BY public.empleado.id_empleado;


--
-- Name: envio; Type: TABLE; Schema: public; Owner: admin
--

CREATE TABLE public.envio (
    id_envio integer NOT NULL,
    id_pedido integer,
    id_paqueteria integer,
    fecha_envio date,
    estado character varying(50)
);


ALTER TABLE public.envio OWNER TO admin;

--
-- Name: envio_id_envio_seq; Type: SEQUENCE; Schema: public; Owner: admin
--

CREATE SEQUENCE public.envio_id_envio_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.envio_id_envio_seq OWNER TO admin;

--
-- Name: envio_id_envio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: admin
--

ALTER SEQUENCE public.envio_id_envio_seq OWNED BY public.envio.id_envio;


--
-- Name: paqueteria; Type: TABLE; Schema: public; Owner: admin
--

CREATE TABLE public.paqueteria (
    id_paqueteria integer NOT NULL,
    nombre character varying(100),
    telefono character varying(20)
);


ALTER TABLE public.paqueteria OWNER TO admin;

--
-- Name: paqueteria_id_paqueteria_seq; Type: SEQUENCE; Schema: public; Owner: admin
--

CREATE SEQUENCE public.paqueteria_id_paqueteria_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.paqueteria_id_paqueteria_seq OWNER TO admin;

--
-- Name: paqueteria_id_paqueteria_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: admin
--

ALTER SEQUENCE public.paqueteria_id_paqueteria_seq OWNED BY public.paqueteria.id_paqueteria;


--
-- Name: pedido; Type: TABLE; Schema: public; Owner: admin
--

CREATE TABLE public.pedido (
    id_pedido integer NOT NULL,
    id_cliente integer,
    fecha timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    estado character varying(50) DEFAULT 'pendiente'::character varying,
    metodo_pago character varying(50),
    total numeric(10,2)
);


ALTER TABLE public.pedido OWNER TO admin;

--
-- Name: pedido_id_pedido_seq; Type: SEQUENCE; Schema: public; Owner: admin
--

CREATE SEQUENCE public.pedido_id_pedido_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pedido_id_pedido_seq OWNER TO admin;

--
-- Name: pedido_id_pedido_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: admin
--

ALTER SEQUENCE public.pedido_id_pedido_seq OWNED BY public.pedido.id_pedido;


--
-- Name: producto; Type: TABLE; Schema: public; Owner: admin
--

CREATE TABLE public.producto (
    id_producto integer NOT NULL,
    nombre character varying(150) NOT NULL,
    descripcion text,
    precio numeric(10,2) NOT NULL,
    stock integer DEFAULT 0,
    id_categoria integer,
    id_proveedor integer
);


ALTER TABLE public.producto OWNER TO admin;

--
-- Name: producto_id_producto_seq; Type: SEQUENCE; Schema: public; Owner: admin
--

CREATE SEQUENCE public.producto_id_producto_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.producto_id_producto_seq OWNER TO admin;

--
-- Name: producto_id_producto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: admin
--

ALTER SEQUENCE public.producto_id_producto_seq OWNED BY public.producto.id_producto;


--
-- Name: programa_lealtad; Type: TABLE; Schema: public; Owner: admin
--

CREATE TABLE public.programa_lealtad (
    id_programa integer NOT NULL,
    id_cliente integer,
    puntos integer DEFAULT 0,
    nivel character varying(50)
);


ALTER TABLE public.programa_lealtad OWNER TO admin;

--
-- Name: programa_lealtad_id_programa_seq; Type: SEQUENCE; Schema: public; Owner: admin
--

CREATE SEQUENCE public.programa_lealtad_id_programa_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.programa_lealtad_id_programa_seq OWNER TO admin;

--
-- Name: programa_lealtad_id_programa_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: admin
--

ALTER SEQUENCE public.programa_lealtad_id_programa_seq OWNED BY public.programa_lealtad.id_programa;


--
-- Name: proveedor; Type: TABLE; Schema: public; Owner: admin
--

CREATE TABLE public.proveedor (
    id_proveedor integer NOT NULL,
    nombre character varying(100) NOT NULL,
    telefono character varying(20),
    email character varying(100)
);


ALTER TABLE public.proveedor OWNER TO admin;

--
-- Name: proveedor_id_proveedor_seq; Type: SEQUENCE; Schema: public; Owner: admin
--

CREATE SEQUENCE public.proveedor_id_proveedor_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.proveedor_id_proveedor_seq OWNER TO admin;

--
-- Name: proveedor_id_proveedor_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: admin
--

ALTER SEQUENCE public.proveedor_id_proveedor_seq OWNED BY public.proveedor.id_proveedor;


--
-- Name: rol; Type: TABLE; Schema: public; Owner: admin
--

CREATE TABLE public.rol (
    id_rol integer NOT NULL,
    nombre character varying(50)
);


ALTER TABLE public.rol OWNER TO admin;

--
-- Name: rol_id_rol_seq; Type: SEQUENCE; Schema: public; Owner: admin
--

CREATE SEQUENCE public.rol_id_rol_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.rol_id_rol_seq OWNER TO admin;

--
-- Name: rol_id_rol_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: admin
--

ALTER SEQUENCE public.rol_id_rol_seq OWNED BY public.rol.id_rol;


--
-- Name: tienda; Type: TABLE; Schema: public; Owner: admin
--

CREATE TABLE public.tienda (
    id_tienda integer NOT NULL,
    nombre character varying(100),
    direccion text
);


ALTER TABLE public.tienda OWNER TO admin;

--
-- Name: tienda_id_tienda_seq; Type: SEQUENCE; Schema: public; Owner: admin
--

CREATE SEQUENCE public.tienda_id_tienda_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tienda_id_tienda_seq OWNER TO admin;

--
-- Name: tienda_id_tienda_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: admin
--

ALTER SEQUENCE public.tienda_id_tienda_seq OWNED BY public.tienda.id_tienda;


--
-- Name: usuario_sistema; Type: TABLE; Schema: public; Owner: admin
--

CREATE TABLE public.usuario_sistema (
    id_usuario integer NOT NULL,
    nombre character varying(100),
    email character varying(100),
    contrasena character varying(100),
    id_rol integer
);


ALTER TABLE public.usuario_sistema OWNER TO admin;

--
-- Name: usuario_sistema_id_usuario_seq; Type: SEQUENCE; Schema: public; Owner: admin
--

CREATE SEQUENCE public.usuario_sistema_id_usuario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuario_sistema_id_usuario_seq OWNER TO admin;

--
-- Name: usuario_sistema_id_usuario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: admin
--

ALTER SEQUENCE public.usuario_sistema_id_usuario_seq OWNED BY public.usuario_sistema.id_usuario;


--
-- Name: venta_pos; Type: TABLE; Schema: public; Owner: admin
--

CREATE TABLE public.venta_pos (
    id_venta integer NOT NULL,
    id_empleado integer,
    id_tienda integer,
    fecha timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    total numeric(10,2)
);


ALTER TABLE public.venta_pos OWNER TO admin;

--
-- Name: venta_pos_id_venta_seq; Type: SEQUENCE; Schema: public; Owner: admin
--

CREATE SEQUENCE public.venta_pos_id_venta_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.venta_pos_id_venta_seq OWNER TO admin;

--
-- Name: venta_pos_id_venta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: admin
--

ALTER SEQUENCE public.venta_pos_id_venta_seq OWNED BY public.venta_pos.id_venta;


--
-- Name: vista_clientes_frecuentes; Type: VIEW; Schema: public; Owner: admin
--

CREATE VIEW public.vista_clientes_frecuentes AS
 SELECT c.id_cliente,
    c.nombre,
    sum(p.total) AS total_gastado,
    count(p.id_pedido) AS compras
   FROM (public.cliente c
     JOIN public.pedido p ON ((c.id_cliente = p.id_cliente)))
  GROUP BY c.id_cliente, c.nombre
  ORDER BY (sum(p.total)) DESC;


ALTER VIEW public.vista_clientes_frecuentes OWNER TO admin;

--
-- Name: vista_inventario_actual; Type: VIEW; Schema: public; Owner: admin
--

CREATE VIEW public.vista_inventario_actual AS
 SELECT p.id_producto,
    p.nombre,
    p.stock,
    c.nombre AS categoria,
    pr.nombre AS proveedor
   FROM ((public.producto p
     JOIN public.categoria c ON ((p.id_categoria = c.id_categoria)))
     JOIN public.proveedor pr ON ((p.id_proveedor = pr.id_proveedor)));


ALTER VIEW public.vista_inventario_actual OWNER TO admin;

--
-- Name: vista_ventas_mensuales; Type: VIEW; Schema: public; Owner: admin
--

CREATE VIEW public.vista_ventas_mensuales AS
 SELECT date_trunc('month'::text, fecha) AS mes,
    sum(total) AS ingresos
   FROM ( SELECT pedido.fecha,
            pedido.total
           FROM public.pedido
        UNION ALL
         SELECT venta_pos.fecha,
            venta_pos.total
           FROM public.venta_pos) t
  GROUP BY (date_trunc('month'::text, fecha))
  ORDER BY (date_trunc('month'::text, fecha)) DESC;


ALTER VIEW public.vista_ventas_mensuales OWNER TO admin;

--
-- Name: categoria id_categoria; Type: DEFAULT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.categoria ALTER COLUMN id_categoria SET DEFAULT nextval('public.categoria_id_categoria_seq'::regclass);


--
-- Name: cliente id_cliente; Type: DEFAULT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.cliente ALTER COLUMN id_cliente SET DEFAULT nextval('public.cliente_id_cliente_seq'::regclass);


--
-- Name: detalle_pedido id_detalle; Type: DEFAULT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.detalle_pedido ALTER COLUMN id_detalle SET DEFAULT nextval('public.detalle_pedido_id_detalle_seq'::regclass);


--
-- Name: detalle_venta_pos id_detalle; Type: DEFAULT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.detalle_venta_pos ALTER COLUMN id_detalle SET DEFAULT nextval('public.detalle_venta_pos_id_detalle_seq'::regclass);


--
-- Name: empleado id_empleado; Type: DEFAULT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.empleado ALTER COLUMN id_empleado SET DEFAULT nextval('public.empleado_id_empleado_seq'::regclass);


--
-- Name: envio id_envio; Type: DEFAULT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.envio ALTER COLUMN id_envio SET DEFAULT nextval('public.envio_id_envio_seq'::regclass);


--
-- Name: paqueteria id_paqueteria; Type: DEFAULT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.paqueteria ALTER COLUMN id_paqueteria SET DEFAULT nextval('public.paqueteria_id_paqueteria_seq'::regclass);


--
-- Name: pedido id_pedido; Type: DEFAULT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.pedido ALTER COLUMN id_pedido SET DEFAULT nextval('public.pedido_id_pedido_seq'::regclass);


--
-- Name: producto id_producto; Type: DEFAULT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.producto ALTER COLUMN id_producto SET DEFAULT nextval('public.producto_id_producto_seq'::regclass);


--
-- Name: programa_lealtad id_programa; Type: DEFAULT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.programa_lealtad ALTER COLUMN id_programa SET DEFAULT nextval('public.programa_lealtad_id_programa_seq'::regclass);


--
-- Name: proveedor id_proveedor; Type: DEFAULT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.proveedor ALTER COLUMN id_proveedor SET DEFAULT nextval('public.proveedor_id_proveedor_seq'::regclass);


--
-- Name: rol id_rol; Type: DEFAULT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.rol ALTER COLUMN id_rol SET DEFAULT nextval('public.rol_id_rol_seq'::regclass);


--
-- Name: tienda id_tienda; Type: DEFAULT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.tienda ALTER COLUMN id_tienda SET DEFAULT nextval('public.tienda_id_tienda_seq'::regclass);


--
-- Name: usuario_sistema id_usuario; Type: DEFAULT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.usuario_sistema ALTER COLUMN id_usuario SET DEFAULT nextval('public.usuario_sistema_id_usuario_seq'::regclass);


--
-- Name: venta_pos id_venta; Type: DEFAULT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.venta_pos ALTER COLUMN id_venta SET DEFAULT nextval('public.venta_pos_id_venta_seq'::regclass);


--
-- Data for Name: categoria; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.categoria (id_categoria, nombre) FROM stdin;
1	computadoras
2	moviles
3	consolas
4	accesorios
\.


--
-- Data for Name: cliente; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.cliente (id_cliente, nombre, email, telefono, direccion) FROM stdin;
101	Ana García	ana.g@mail.com	5511223344	Calle Falsa 123, Ciudad A
102	Juan Pérez	juanp@mail.com	5598765432	Av. Siempreviva 742, Ciudad B
103	María López	marial@mail.com	5555667788	Blvd. del Sol 50, Ciudad A
104	Carlos Ruiz	carlosr@mail.com	5544332211	Sector Oriente 8, Ciudad C
105	Sofía Díaz	sofiad@mail.com	5577889900	Pza. Central 1, Ciudad A
106	Luis Torres	luist@mail.com	5512345678	Calle Principal 99, Ciudad B
107	Elena Castro	elenac@mail.com	5500998877	Ruta 5 Km 10, Ciudad C
\.


--
-- Data for Name: detalle_pedido; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.detalle_pedido (id_detalle, id_pedido, id_producto, cantidad, subtotal) FROM stdin;
501	1	2002	1	349.99
503	2	2004	1	79.99
504	3	2003	3	179.97
505	4	2001	1	899.99
\.


--
-- Data for Name: detalle_venta_pos; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.detalle_venta_pos (id_detalle, id_venta, id_producto, cantidad, subtotal) FROM stdin;
801	1001	2004	1	29.99
802	1001	2003	1	79.99
803	1002	2001	1	59.99
804	1003	2002	1	349.99
\.


--
-- Data for Name: empleado; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.empleado (id_empleado, nombre, cargo, email, id_tienda) FROM stdin;
1	Rodrigo Méndez	Gerente	rod.m@mail.com	1
2	Valeria Soto	Vendedor	val.s@mail.com	1
3	Pablo Reyes	Cajero	pablo.r@mail.com	1
4	Isabel Gil	Vendedor	isa.g@mail.com	2
5	Diego Cruz	Gerente	diego.c@mail.com	2
6	Lucía Vidal	Almacenista	lucia.v@mail.com	3
7	Javier Luna	Vendedor	jav.l@mail.com	3
\.


--
-- Data for Name: envio; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.envio (id_envio, id_pedido, id_paqueteria, fecha_envio, estado) FROM stdin;
501	1	1	2025-11-15	Entregado
502	2	2	2025-11-16	En Tránsito
503	3	1	2025-11-16	Entregado
504	4	3	2025-11-17	Pendiente
505	5	2	2025-11-18	En Tránsito
\.


--
-- Data for Name: paqueteria; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.paqueteria (id_paqueteria, nombre, telefono) FROM stdin;
1	Rápido Express	5566778899
2	Global Logística	5511009988
3	Envíos Seguros	5533445566
4	Paq Plus	5501010101
5	Veloz Entregas	5520202020
\.


--
-- Data for Name: pedido; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.pedido (id_pedido, id_cliente, fecha, estado, metodo_pago, total) FROM stdin;
1	101	2025-11-14 00:00:00	Completado	Tarjeta Crédito	249.97
2	102	2025-11-15 00:00:00	En Proceso	PayPal	29.97
3	103	2025-11-15 00:00:00	Completado	Tarjeta Débito	19.99
4	104	2025-11-16 00:00:00	Pendiente	Transferencia	399.99
5	105	2025-11-17 00:00:00	En Proceso	Tarjeta Crédito	99.99
\.


--
-- Data for Name: producto; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.producto (id_producto, nombre, descripcion, precio, stock, id_categoria, id_proveedor) FROM stdin;
2001	Laptop Ultradelgada	Portátil 14" con 16GB RAM	899.99	150	1	1
2002	Smartphone Z10	Teléfono gama media, 128GB	349.99	300	2	1
2003	Consola Next-Gen	Consola de videojuegos 1TB	499.99	75	3	6
2004	Monitor Curvo 27"	Monitor para juegos 144Hz	299.99	500	1	2
\.


--
-- Data for Name: programa_lealtad; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.programa_lealtad (id_programa, id_cliente, puntos, nivel) FROM stdin;
401	101	500	Oro
402	102	150	Plata
403	103	250	Bronce
404	104	1000	Oro
405	105	50	Bronce
406	106	0	Bronce
407	107	300	Plata
\.


--
-- Data for Name: proveedor; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.proveedor (id_proveedor, nombre, telefono, email) FROM stdin;
1	Tech Solutions S.A.	5511221122	contacto@techsol.com
2	Home Goods Co.	5533443344	ventas@homegoods.com
3	Green Life Ltda.	5555665566	info@greenlife.com
4	Fashion Direct	5577887788	soporte@fashiondirect.com
5	Healthy Snacks Inc.	5599009900	pedidos@healthysnacks.com
6	Toy World	5510203040	contacto@toyworld.com
7	Sport Gear	5521436587	ventas@sportgear.com
\.


--
-- Data for Name: rol; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.rol (id_rol, nombre) FROM stdin;
1	Administrador
2	Gerente
3	Vendedor
4	Cajero
5	Almacenista
6	Supervisor
7	Contable
\.


--
-- Data for Name: tienda; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.tienda (id_tienda, nombre, direccion) FROM stdin;
1	Tienda Central	Av. Principal 90, Centro
2	Tienda Sur	Calle 3 Sur 20, Col Pedregal
3	Tienda Norte	Blvd. Industrial 500, Zona Norte
4	Tienda Este	Plaza Comercial 1
5	Tienda Oeste	Av Oeste No.8
\.


--
-- Data for Name: usuario_sistema; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.usuario_sistema (id_usuario, nombre, email, contrasena, id_rol) FROM stdin;
1	David Admin	d.admin@mail.com	09876	1
2	Rodrigo M.	rod.m@mail.com	3456	2
3	Valeria S.	val.s@mail.com	1234	3
4	Isabel G.	isa.g@mail.com	87654	3
5	Diego C.	diego.c@mail.com	123455	2
\.


--
-- Data for Name: venta_pos; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.venta_pos (id_venta, id_empleado, id_tienda, fecha, total) FROM stdin;
1001	2	1	2025-11-19 00:00:00	29.97
1002	3	1	2025-11-19 00:00:00	9.99
1003	4	2	2025-11-19 00:00:00	99.99
1004	2	1	2025-11-19 00:00:00	79.96
1005	5	3	2025-11-19 00:00:00	399.99
1006	4	2	2025-11-19 00:00:00	49.99
\.


--
-- Name: categoria_id_categoria_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.categoria_id_categoria_seq', 1, false);


--
-- Name: cliente_id_cliente_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.cliente_id_cliente_seq', 1, false);


--
-- Name: detalle_pedido_id_detalle_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.detalle_pedido_id_detalle_seq', 1, false);


--
-- Name: detalle_venta_pos_id_detalle_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.detalle_venta_pos_id_detalle_seq', 1, false);


--
-- Name: empleado_id_empleado_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.empleado_id_empleado_seq', 1, false);


--
-- Name: envio_id_envio_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.envio_id_envio_seq', 1, false);


--
-- Name: paqueteria_id_paqueteria_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.paqueteria_id_paqueteria_seq', 1, false);


--
-- Name: pedido_id_pedido_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.pedido_id_pedido_seq', 1, false);


--
-- Name: producto_id_producto_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.producto_id_producto_seq', 1, false);


--
-- Name: programa_lealtad_id_programa_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.programa_lealtad_id_programa_seq', 1, false);


--
-- Name: proveedor_id_proveedor_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.proveedor_id_proveedor_seq', 1, false);


--
-- Name: rol_id_rol_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.rol_id_rol_seq', 1, false);


--
-- Name: tienda_id_tienda_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.tienda_id_tienda_seq', 1, false);


--
-- Name: usuario_sistema_id_usuario_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.usuario_sistema_id_usuario_seq', 1, false);


--
-- Name: venta_pos_id_venta_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.venta_pos_id_venta_seq', 1, false);


--
-- Name: categoria categoria_pkey; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.categoria
    ADD CONSTRAINT categoria_pkey PRIMARY KEY (id_categoria);


--
-- Name: cliente cliente_email_key; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.cliente
    ADD CONSTRAINT cliente_email_key UNIQUE (email);


--
-- Name: cliente cliente_pkey; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.cliente
    ADD CONSTRAINT cliente_pkey PRIMARY KEY (id_cliente);


--
-- Name: detalle_pedido detalle_pedido_pkey; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_pkey PRIMARY KEY (id_detalle);


--
-- Name: detalle_venta_pos detalle_venta_pos_pkey; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.detalle_venta_pos
    ADD CONSTRAINT detalle_venta_pos_pkey PRIMARY KEY (id_detalle);


--
-- Name: empleado empleado_pkey; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.empleado
    ADD CONSTRAINT empleado_pkey PRIMARY KEY (id_empleado);


--
-- Name: envio envio_pkey; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.envio
    ADD CONSTRAINT envio_pkey PRIMARY KEY (id_envio);


--
-- Name: paqueteria paqueteria_pkey; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.paqueteria
    ADD CONSTRAINT paqueteria_pkey PRIMARY KEY (id_paqueteria);


--
-- Name: pedido pedido_pkey; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.pedido
    ADD CONSTRAINT pedido_pkey PRIMARY KEY (id_pedido);


--
-- Name: producto producto_pkey; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.producto
    ADD CONSTRAINT producto_pkey PRIMARY KEY (id_producto);


--
-- Name: programa_lealtad programa_lealtad_pkey; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.programa_lealtad
    ADD CONSTRAINT programa_lealtad_pkey PRIMARY KEY (id_programa);


--
-- Name: proveedor proveedor_pkey; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.proveedor
    ADD CONSTRAINT proveedor_pkey PRIMARY KEY (id_proveedor);


--
-- Name: rol rol_pkey; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.rol
    ADD CONSTRAINT rol_pkey PRIMARY KEY (id_rol);


--
-- Name: tienda tienda_pkey; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.tienda
    ADD CONSTRAINT tienda_pkey PRIMARY KEY (id_tienda);


--
-- Name: usuario_sistema usuario_sistema_email_key; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.usuario_sistema
    ADD CONSTRAINT usuario_sistema_email_key UNIQUE (email);


--
-- Name: usuario_sistema usuario_sistema_pkey; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.usuario_sistema
    ADD CONSTRAINT usuario_sistema_pkey PRIMARY KEY (id_usuario);


--
-- Name: venta_pos venta_pos_pkey; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.venta_pos
    ADD CONSTRAINT venta_pos_pkey PRIMARY KEY (id_venta);


--
-- Name: detalle_pedido detalle_pedido_id_pedido_fkey; Type: FK CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_id_pedido_fkey FOREIGN KEY (id_pedido) REFERENCES public.pedido(id_pedido);


--
-- Name: detalle_pedido detalle_pedido_id_producto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_id_producto_fkey FOREIGN KEY (id_producto) REFERENCES public.producto(id_producto);


--
-- Name: detalle_venta_pos detalle_venta_pos_id_producto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.detalle_venta_pos
    ADD CONSTRAINT detalle_venta_pos_id_producto_fkey FOREIGN KEY (id_producto) REFERENCES public.producto(id_producto);


--
-- Name: detalle_venta_pos detalle_venta_pos_id_venta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.detalle_venta_pos
    ADD CONSTRAINT detalle_venta_pos_id_venta_fkey FOREIGN KEY (id_venta) REFERENCES public.venta_pos(id_venta);


--
-- Name: empleado empleado_id_tienda_fkey; Type: FK CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.empleado
    ADD CONSTRAINT empleado_id_tienda_fkey FOREIGN KEY (id_tienda) REFERENCES public.tienda(id_tienda);


--
-- Name: envio envio_id_paqueteria_fkey; Type: FK CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.envio
    ADD CONSTRAINT envio_id_paqueteria_fkey FOREIGN KEY (id_paqueteria) REFERENCES public.paqueteria(id_paqueteria);


--
-- Name: envio envio_id_pedido_fkey; Type: FK CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.envio
    ADD CONSTRAINT envio_id_pedido_fkey FOREIGN KEY (id_pedido) REFERENCES public.pedido(id_pedido);


--
-- Name: pedido pedido_id_cliente_fkey; Type: FK CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.pedido
    ADD CONSTRAINT pedido_id_cliente_fkey FOREIGN KEY (id_cliente) REFERENCES public.cliente(id_cliente);


--
-- Name: producto producto_id_categoria_fkey; Type: FK CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.producto
    ADD CONSTRAINT producto_id_categoria_fkey FOREIGN KEY (id_categoria) REFERENCES public.categoria(id_categoria);


--
-- Name: producto producto_id_proveedor_fkey; Type: FK CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.producto
    ADD CONSTRAINT producto_id_proveedor_fkey FOREIGN KEY (id_proveedor) REFERENCES public.proveedor(id_proveedor);


--
-- Name: programa_lealtad programa_lealtad_id_cliente_fkey; Type: FK CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.programa_lealtad
    ADD CONSTRAINT programa_lealtad_id_cliente_fkey FOREIGN KEY (id_cliente) REFERENCES public.cliente(id_cliente);


--
-- Name: usuario_sistema usuario_sistema_id_rol_fkey; Type: FK CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.usuario_sistema
    ADD CONSTRAINT usuario_sistema_id_rol_fkey FOREIGN KEY (id_rol) REFERENCES public.rol(id_rol);


--
-- Name: venta_pos venta_pos_id_empleado_fkey; Type: FK CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.venta_pos
    ADD CONSTRAINT venta_pos_id_empleado_fkey FOREIGN KEY (id_empleado) REFERENCES public.empleado(id_empleado);


--
-- Name: venta_pos venta_pos_id_tienda_fkey; Type: FK CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.venta_pos
    ADD CONSTRAINT venta_pos_id_tienda_fkey FOREIGN KEY (id_tienda) REFERENCES public.tienda(id_tienda);


--
-- PostgreSQL database dump complete
--

