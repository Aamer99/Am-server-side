const mongoose = require("mongoose");

const SubmissionsSchema = new mongoose.Schema({
  content: { type: Array, require },
  form_id: { type: String, require },
});

module.exports = mongoose.model("Submissions", SubmissionsSchema);
