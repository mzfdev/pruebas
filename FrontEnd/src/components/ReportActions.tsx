import React, { useState } from 'react';
import { GradeReport, reportService } from '../services/api';
import './ReportActions.css';

interface ReportActionsProps {
  report: GradeReport | null;
  onClose: () => void;
}

const ReportActions: React.FC<ReportActionsProps> = ({ report, onClose }) => {
  const [isGeneratingPdf, setIsGeneratingPdf] = useState(false);
  const [isSendingEmail, setIsSendingEmail] = useState(false);
  const [isPrinting, setIsPrinting] = useState(false);
  const [message, setMessage] = useState<{ type: 'success' | 'error'; text: string } | null>(null);

  const handleGeneratePdf = async () => {
    if (!report) return;
    
    setIsGeneratingPdf(true);
    setMessage(null);
    
    try {
      const response = await reportService.generatePdf(report.report_id, 1);
      
      if (response.success) {
        setMessage({ type: 'success', text: 'PDF generado exitosamente' });
        
        // Download the PDF
        const pdfBlob = await reportService.downloadPdf(response.data.file_path.split('/').pop() || '');
        const url = window.URL.createObjectURL(pdfBlob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `reporte_${report.student.carnet}.pdf`;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
      }
    } catch (error) {
      setMessage({ type: 'error', text: 'Error al generar el PDF' });
      console.error('Error generating PDF:', error);
    } finally {
      setIsGeneratingPdf(false);
    }
  };

  const handleSendEmail = async () => {
    if (!report) return;
    
    setIsSendingEmail(true);
    setMessage(null);
    
    try {
      const response = await reportService.sendByEmail(report.report_id);
      
      if (response.success) {
        setMessage({ type: 'success', text: 'Reporte enviado por correo exitosamente' });
      } else {
        setMessage({ type: 'error', text: response.message || 'Error al enviar el correo' });
      }
    } catch (error) {
      setMessage({ type: 'error', text: 'Error al enviar el correo' });
      console.error('Error sending email:', error);
    } finally {
      setIsSendingEmail(false);
    }
  };

  const handlePrint = async () => {
    if (!report) return;
    
    setIsPrinting(true);
    setMessage(null);
    
    try {
      const response = await reportService.printReport(report.report_id);
      
      if (response.success) {
        setMessage({ type: 'success', text: 'Reporte enviado a impresión exitosamente' });
      } else {
        setMessage({ type: 'error', text: response.message || 'Error al imprimir el reporte' });
      }
    } catch (error) {
      setMessage({ type: 'error', text: 'Error al imprimir el reporte' });
      console.error('Error printing report:', error);
    } finally {
      setIsPrinting(false);
    }
  };

  if (!report) return null;

  return (
    <div className="report-actions-overlay">
      <div className="report-actions-modal">
        <div className="report-actions-header">
          <h2>Acciones del Reporte</h2>
          <button className="close-btn" onClick={onClose}>×</button>
        </div>
        
        <div className="report-summary">
          <h3>Resumen del Estudiante</h3>
          <p><strong>Nombre:</strong> {report.student.name} {report.student.lastname}</p>
          <p><strong>Carnet:</strong> {report.student.carnet}</p>
          <p><strong>Total de Materias:</strong> {report.summary.total_subjects}</p>
          <p><strong>Materias Aprobadas:</strong> {report.summary.approved_subjects}</p>
          <p><strong>Materias Reprobadas:</strong> {report.summary.failed_subjects}</p>
          <p><strong>Promedio:</strong> {report.summary.average_grade}</p>
          <p><strong>Total UV:</strong> {report.summary.total_uv}</p>
        </div>

        {message && (
          <div className={`message ${message.type}`}>
            {message.text}
          </div>
        )}

        <div className="report-actions-buttons">
          <button
            className="action-btn pdf-btn"
            onClick={handleGeneratePdf}
            disabled={isGeneratingPdf}
          >
            {isGeneratingPdf ? 'Generando PDF...' : 'Generar y Descargar PDF'}
          </button>
          
          <button
            className="action-btn email-btn"
            onClick={handleSendEmail}
            disabled={isSendingEmail}
          >
            {isSendingEmail ? 'Enviando...' : 'Enviar por Correo'}
          </button>
          
          <button
            className="action-btn print-btn"
            onClick={handlePrint}
            disabled={isPrinting}
          >
            {isPrinting ? 'Imprimiendo...' : 'Imprimir'}
          </button>
        </div>
      </div>
    </div>
  );
};

export default ReportActions;