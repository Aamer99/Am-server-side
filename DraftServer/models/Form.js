const mongoose = require("mongoose");

const FormSchema = new mongoose.Schema({
  content: { type: Array, require },
  owner_id: { type: String, require },
  form_name: { type: String, require },
});

module.exports = mongoose.model("Forms", FormSchema);
