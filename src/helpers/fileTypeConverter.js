export async function fileTypeConverter(source, size, format, fileName) {
  const canvas = document.createElement('canvas');
  const img = document.createElement('img');

  img.src = source;
  img.width = size;
  img.height = size;

  const ctx = canvas.getContext('2d');

  canvas.width = size;
  canvas.height = size;

  // Draw image on the canvas
  ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

  let downloadLink = document.createElement('a');

  if (format === 'svg') {
    // Convert to SVG
    const link = document.createElement('a');
    link.href = source;
    link.download = `${fileName}.${format}`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  } else if (format === 'pdf') {
    // Convert to PDF using jsPDF
    const { jsPDF } = await import('jspdf');
    const pdf = new jsPDF();
    pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 10, 10, 180, 150);
    pdf.save('downloaded-image.pdf');
    return;
  } else {
    // For PNG or JPEG
    downloadLink.href = canvas.toDataURL(`image/${format}`);
    downloadLink.download = `${fileName}.${format}`;
  }

  downloadLink.click();
}
