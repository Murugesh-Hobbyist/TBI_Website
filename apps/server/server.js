const path = require('path');
const fs = require('fs');
const express = require('express');
const session = require('express-session');
const MySQLStore = require('express-mysql-session')(session);
const next = require('next');
require('dotenv').config({ path: path.join(__dirname, '..', '..', '.env') });

const { setupVoiceServer } = require('./src/voice/voiceServer');

const productsRoute = require('./src/routes/products');
const cartRoute = require('./src/routes/cart');
const ordersRoute = require('./src/routes/orders');
const quotesRoute = require('./src/routes/quotes');
const forumRoute = require('./src/routes/forum');
const adminRoute = require('./src/routes/admin');
const voiceRoute = require('./src/routes/voice');

const dev = process.env.NODE_ENV !== 'production';
const port = Number(process.env.PORT || 3000);
const webDir = path.join(__dirname, '../web');

const nextApp = next({ dev, dir: webDir });
const handle = nextApp.getRequestHandler();

nextApp.prepare().then(() => {
  const app = express();

  app.use(express.json({ limit: '10mb' }));
  app.use(express.urlencoded({ extended: true }));

  app.get('/healthz', (req, res) => {
    res.json({ ok: true });
  });
  app.get('/api/healthz', (req, res) => {
    res.json({ ok: true });
  });

  const hasDb =
    Boolean(process.env.DB_HOST) &&
    Boolean(process.env.DB_USER) &&
    Boolean(process.env.DB_NAME);

  let sessionStore;
  if (hasDb) {
    try {
      sessionStore = new MySQLStore({
        host: process.env.DB_HOST,
        user: process.env.DB_USER,
        password: process.env.DB_PASSWORD,
        database: process.env.DB_NAME,
        port: Number(process.env.DB_PORT || 3306)
      });
    } catch (err) {
      // Allow the app to boot even if DB is temporarily unavailable.
      console.error('Session store init failed, falling back to MemoryStore:', err.message || err);
      sessionStore = undefined;
    }
  } else {
    console.warn('DB env not fully configured; using MemoryStore for sessions.');
  }

  app.use(
    session({
      key: 'tbi.sid',
      secret: process.env.SESSION_SECRET || 'change_me',
      store: sessionStore,
      resave: false,
      saveUninitialized: false,
      cookie: { httpOnly: true, maxAge: 1000 * 60 * 60 * 24 }
    })
  );

  const envUpload = process.env.UPLOAD_DIR;
  const uploadDir = envUpload
    ? (path.isAbsolute(envUpload) ? envUpload : path.join(process.cwd(), envUpload))
    : path.join(__dirname, 'uploads');
  if (!fs.existsSync(uploadDir)) {
    fs.mkdirSync(uploadDir, { recursive: true });
  }
  app.use('/uploads', express.static(uploadDir));

  app.use('/api/products', productsRoute);
  app.use('/api/cart', cartRoute);
  app.use('/api/orders', ordersRoute);
  app.use('/api/quotes', quotesRoute);
  app.use('/api/forum', forumRoute);
  app.use('/api/admin', adminRoute);
  app.use('/api/voice', voiceRoute);

  app.all('*', (req, res) => handle(req, res));

  const host = process.env.HOST || '0.0.0.0';
  const server = app.listen(port, host, () => {
    console.log(`Server ready on http://${host}:${port}`);
  });

  setupVoiceServer(server);
});
