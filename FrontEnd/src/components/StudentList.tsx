import React, { useState, useEffect } from 'react';
import { Student, GradeReport, studentService } from '../services/api';
import StudentCard from './StudentCard';
import ReportActions from './ReportActions';
import './StudentList.css';

const StudentList: React.FC = () => {
  const [students, setStudents] = useState<Student[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [selectedReport, setSelectedReport] = useState<GradeReport | null>(null);
  const [generatingReportFor, setGeneratingReportFor] = useState<number | null>(null);

  useEffect(() => {
    fetchStudents();
  }, []);

  const fetchStudents = async () => {
    try {
      setLoading(true);
      setError(null);
      const response = await studentService.getStudents();
      
      if (response.success) {
        setStudents(response.data);
      } else {
        setError('Error al cargar los estudiantes');
      }
    } catch (err) {
      setError('Error de conexión al servidor');
      console.error('Error fetching students:', err);
    } finally {
      setLoading(false);
    }
  };

  const handleGenerateReport = async (studentId: number) => {
    try {
      setGeneratingReportFor(studentId);
      const response = await studentService.getGradeReport(studentId);
      
      if (response.success) {
        setSelectedReport(response.data);
      } else {
        setError('Error al generar el reporte');
      }
    } catch (err) {
      setError('Error al generar el reporte');
      console.error('Error generating report:', err);
    } finally {
      setGeneratingReportFor(null);
    }
  };

  const handleCloseReportActions = () => {
    setSelectedReport(null);
  };

  if (loading) {
    return (
      <div className="student-list-container">
        <div className="loading">Cargando estudiantes...</div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="student-list-container">
        <div className="error">
          <p>{error}</p>
          <button onClick={fetchStudents} className="retry-btn">
            Reintentar
          </button>
        </div>
      </div>
    );
  }

  return (
    <div className="student-list-container">
      <header className="student-list-header">
        <img src="/Logo_UCA_2015.jpg" alt="UCA Logo" className="uca-logo" />
        <h1>Lista de Estudiantes</h1>
        <p>Total de estudiantes: {students.length}</p>
      </header>
      
      <div className="students-grid">
        {students.map((student) => (
          <StudentCard
            key={student.id}
            student={student}
            onGenerateReport={handleGenerateReport}
            isLoading={generatingReportFor === student.id}
          />
        ))}
      </div>

      {students.length === 0 && (
        <div className="no-students">
          <p>No hay estudiantes registrados</p>
        </div>
      )}

      {selectedReport && (
        <ReportActions
          report={selectedReport}
          onClose={handleCloseReportActions}
        />
      )}
    </div>
  );
};

export default StudentList;