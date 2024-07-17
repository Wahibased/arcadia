const express = require('express');
const mongoose = require('mongoose');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();
const port = process.env.PORT || 3003
;

// Middleware
app.use(bodyParser.json());
app.use(cors());

// MongoDB connection
mongoose.connect('mongodb://localhost:27017/animaux', {
    useNewUrlParser: true,
    useUnifiedTopology: true
});

const db = mongoose.connection;
db.on('error', console.error.bind(console, 'connection error:'));
db.once('open', () => {
    console.log('Connected to MongoDB');
});

// Mongoose schema and model
const animalSchema = new mongoose.Schema({
    id: String,
    count: Number
});

const Animal = mongoose.model('Animal', animalSchema);

// API endpoints
app.get('/api/animals', async (req, res) => {
    try {
        const animals = await Animal.find();
        res.json(animals);
    } catch (err) {
        res.status(500).send(err);
    }
});

app.post('/api/increment', async (req, res) => {
    const { id } = req.body;
    try {
        let animal = await Animal.findOne({ id });
        if (animal) {
            animal.count += 1;
        } else {
            animal = new Animal({ id, count: 1 });
        }
        await animal.save();
        res.json(animal);
    } catch (err) {
        res.status(500).send(err);
    }
});

app.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});
