const express = require('express');
const multer = require('multer');
const path = require('path');
const controller = require('../controllers/quoteController');
const { requireAdmin } = require('../middleware/auth');

const envUpload = process.env.UPLOAD_DIR;
const uploadDir = envUpload
  ? (path.isAbsolute(envUpload) ? envUpload : path.join(process.cwd(), envUpload))
  : path.join(__dirname, '../../uploads');
const storage = multer.diskStorage({
  destination: (req, file, cb) => cb(null, uploadDir),
  filename: (req, file, cb) => {
    const safeName = Date.now() + '-' + file.originalname.replace(/\s+/g, '-');
    cb(null, safeName);
  }
});

const upload = multer({ storage });
const router = express.Router();

router.post('/', upload.single('file'), controller.create);
router.get('/', requireAdmin, controller.list);

module.exports = router;
