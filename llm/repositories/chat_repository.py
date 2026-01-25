from typing import List, Dict, Any, Optional
from decimal import Decimal
from database import get_mysql_connection
import logging
from contextlib import contextmanager

logger = logging.getLogger(__name__)

class RawSQLRepository:
    """Репозиторий с сырыми SQL запросами"""

    @contextmanager
    def get_connection(self):
        """Контекстный менеджер для подключения"""
        connection = get_mysql_connection()
        try:
            yield connection
        finally:
            connection.close()

    def execute_query(self, query: str, params: tuple = None, fetch: bool = True) -> Any:
        """Выполнение SQL запроса"""
        with self.get_connection() as conn:
            cursor = conn.cursor(dictionary=True)
            try:
                cursor.execute(query, params or ())

                if fetch:
                    if query.strip().upper().startswith('SELECT'):
                        result = cursor.fetchall()
                    else:
                        conn.commit()
                        result = cursor.lastrowid
                else:
                    conn.commit()
                    result = cursor.rowcount

                return result
            except Exception as e:
                conn.rollback()
                logger.error(f"Error executing query: {e}")
                raise
            finally:
                cursor.close()

    # Примеры CRUD операций

    def get_user_by_id(self, user_id: int) -> Optional[Dict[str, Any]]:
        """Получение пользователя по ID"""
        query = """
        SELECT
            id, username, email, full_name, is_active,
            created_at, updated_at
        FROM users
        WHERE id = %s
        """
        result = self.execute_query(query, (user_id,))
        return result[0] if result else None

    def get_all_users(self, limit: int = 100, offset: int = 0) -> List[Dict[str, Any]]:
        """Получение всех пользователей с пагинацией"""
        query = """
        SELECT
            id, username, email, full_name, is_active,
            created_at, updated_at
        FROM users
        ORDER BY created_at DESC
        LIMIT %s OFFSET %s
        """
        return self.execute_query(query, (limit, offset))

