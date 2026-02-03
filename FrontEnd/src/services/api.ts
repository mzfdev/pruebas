import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api';

const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

export interface Student {
  id: number;
  carnet: string;
  name: string;
  lastname: string;
  email: string;
  created_at: string;
  updated_at: string;
}

export interface Subject {
  id: number;
  code: string;
  name: string;
  uv: number;
}

export interface Grade {
  subject: Subject;
  qualification: number;
  coursed_times: number;
  status: string;
}

export interface GradeReport {
  report_id: number;
  student: Student;
  grades: Grade[];
  summary: {
    total_subjects: number;
    approved_subjects: number;
    failed_subjects: number;
    average_grade: number;
    total_uv: number;
  };
}

export interface ApiResponse<T> {
  success: boolean;
  data: T;
  message?: string;
  errors?: any;
}

export const studentService = {
  getStudents: async (): Promise<ApiResponse<Student[]>> => {
    const response = await api.get('/students');
    return response.data;
  },

  getGradeReport: async (studentId: number): Promise<ApiResponse<GradeReport>> => {
    const response = await api.get(`/students/${studentId}/grade-report`);
    return response.data;
  },
};

export const reportService = {
  generatePdf: async (reportId: number, formatId: number): Promise<ApiResponse<{ file_path: string; url: string }>> => {
    const response = await api.post('/reports/generate-pdf', { report_id: reportId, format_id: formatId });
    return response.data;
  },

  downloadPdf: async (fileName: string): Promise<Blob> => {
    const response = await api.get(`/reports/download/${fileName}`, {
      responseType: 'blob',
    });
    return response.data;
  },

  sendByEmail: async (reportId: number): Promise<ApiResponse<any>> => {
    const response = await api.post('/reports/send-by-email', { report_id: reportId });
    return response.data;
  },

  printReport: async (reportId: number): Promise<ApiResponse<any>> => {
    const response = await api.post('/reports/print', { report_id: reportId });
    return response.data;
  },
};

export default api;