const express = require('express');
const PDFDocument = require('pdfkit');
const fs = require('fs');
const mysql = require('mysql');

const app = express();
const port = 3001;

// Configuración de la conexión a la base de datos MySQL
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'nicolas',
  password: 'nico05alva20',
  database: 'perros',
});

// Conexión a la base de datos
connection.connect((err) => {
  if (err) {
    console.error('Error al conectar a la base de datos:', err);
    return;
  }
  console.log('Conexión exitosa a la base de datos');
});

app.get('/descargar-pdf', (req, res) => {
  // Consulta a la base de datos para obtener la lista de perros
  connection.query('SELECT * FROM perros', (error, results) => {
    if (error) {
      console.error('Error al obtener la lista de perros:', error);
      res.status(500).send('Error al obtener la lista de perros');
      return;
    }

    // Crear un nuevo documento PDF
    const doc = new PDFDocument();

    // Configurar el encabezado y el tipo de contenido de la respuesta
    res.setHeader('Content-Type', 'application/pdf');
    res.setHeader('Content-Disposition', 'attachment; filename="archivo.pdf"');

    // Pipe el contenido del PDF directamente a la respuesta HTTP
    doc.pipe(res);

    // Configurar las columnas
    const column1X = 50;
    const column2X = 200;
    const columnWidth = 150;
    const lineHeight = 20;

    // Añadir contenido al PDF
    doc.fontSize(16).text('Lista de Perros', { align: 'center' });
    doc.moveDown();

    // Recorrer la lista de perros y agregarlos al PDF en columnas
    results.forEach((perro, index) => {
      const y = doc.y + (index * lineHeight);
      doc.text(`${index + 1}.`, column1X, y);
      doc.text(perro.name, column2X, y);
      doc.text(`Raza: ${perro.race}`, column2X, y + lineHeight);
      doc.text(`Tamaño: ${perro.size}`, column2X, y + 2 * lineHeight);
      doc.text(`Color: ${perro.hair_color}`, column2X, y + 3 * lineHeight);
      doc.moveDown();
    });

    // Finalizar y cerrar el documento PDF
    doc.end();
  });
});

app.listen(port, () => {
  console.log(`Servidor Node.js en funcionamiento en el puerto ${port}`);
});
