const express = require("express");
const router = express.Router();
const Forms = require("../models/Form.js");

// create my from
router.post("/", async (req, res) => {
  try {
    let form = new Forms({
      content: req.body.content,
      owner_id: req.body.owner_id,
      form_name: req.body.form_name,
    });

    const newForm = await form.save();

    return res.status(200).json(newForm.id);
  } catch (error) {
    return res.status(400).json({ message: new Error(error.message) });
  }
});

//get on form

router.get("/:id", async (req, res) => {
  try {
    let form = await Forms.findById(req.params.id);
    if (form) {
      return res.status(200).json({ form: form });
    } else {
      return res.status(404).json({ message: "not found" });
    }
  } catch (error) {
    return res.status(400).json({ message: "please try again" });
  }
});

//get user forms
router.get("/user-forms/:id", async (req, res) => {
  try {
    let forms = await Forms.find({ owner_id: req.params.id });
    return res.status(200).json({ forms: forms });
  } catch (error) {
    return res.status(400).json({ message: "please try again" });
  }
});

//edit  form
router.patch("/:id", async (req, res) => {
  try {
    let form = await Forms.findById(req.params.id);
    console.log(form);
    if (form) {
      form.content = req.body.content;
      form.form_name = req.body.form_name;
      form.save();

      return res.status(200).json({ form: form });
    } else {
      return res.status(404).json({ message: "not found" });
    }
  } catch (error) {
    throw new Error(error.message);
    return res.status(400).json({ message: "please try again" });
  }
});

module.exports = router;
