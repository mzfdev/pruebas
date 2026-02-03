import React from 'react';
import { Student } from '../services/api';
import './StudentCard.css';

interface StudentCardProps {
  student: Student;
  onGenerateReport: (studentId: number) => void;
  isLoading?: boolean;
}

const StudentCard: React.FC<StudentCardProps> = ({ student, onGenerateReport, isLoading = false }) => {
  return (
    <div className="student-card">
      <div className="student-info">
        <h3 className="student-name">
          {student.name} {student.lastname}
        </h3>
        <p className="student-carnet">
          <strong>Carnet:</strong> {student.carnet}
        </p>
        <p className="student-email">
          <strong>Email:</strong> {student.email}
        </p>
      </div>
      <div className="student-actions">
        <button
          className="generate-report-btn"
          onClick={() => onGenerateReport(student.id)}
          disabled={isLoading}
        >
          {isLoading ? 'Generando...' : 'Generar Reporte'}
        </button>
      </div>
    </div>
  );
};

export default StudentCard;