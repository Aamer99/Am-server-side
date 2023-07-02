const express = require("express");
const Submission = require("../models/Submission.js");
const router = express.Router();

router.post("/", async (req, res) => {
  try {
    let submission = new Submission({
      content: req.body.content,
      form_id: req.body.form_id,
    });

    const newSubmission = await submission.save();

    return res.status(200).json(newSubmission.form_id);
  } catch (error) {
    return res.status(400).json({ message: new Error(error.message) });
  }
});

router.get("/:id", async (req, res) => {
  try {
    const submitData = await Submission.find({ form_id: req.params.id });

    if (submitData) {
      return res.status(200).json(submitData);
    } else {
      return res.status(404).json({ message: "not found" });
    }
  } catch (error) {
    return res
      .status(400)
      .json({ message: "something was wrong please try again later " });
  }
});

module.exports = router;
