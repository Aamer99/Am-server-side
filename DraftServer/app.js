require("dotenv").config();
var express = require("express");
const mongoose = require("mongoose");
var bodyParser = require("body-parser");

var app = express();

//connect to the database
mongoose.connect(process.env.DATABASE_ACCESS, {
  useNewUrlParser: true,
});
const db = mongoose.connection;
db.on("error", (error) => console.log(error));
db.once("open", () => console.log("connected to mongodb"));

//setup the routes
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

const form = require("./routes/Form.js");
const submission = require("./routes/Submission.js");

app.use("/draft-db/form", form);
app.use("/draft-db/submission", submission);

// connect to the server
app.listen(3001, function () {
  console.log("the draft server work on port 3001!");
});
