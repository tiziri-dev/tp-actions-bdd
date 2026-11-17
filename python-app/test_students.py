import pytest
from students import get_connection, add_student, get_student, average_grade

@pytest.fixture
def conn():
    connection = get_connection()
    with connection.cursor() as cur:
        cur.execute("TRUNCATE TABLE students RESTART IDENTITY;")
    connection.commit()
    yield connection
    connection.close()

def test_add_and_get(conn):
    add_student(conn, "Alice", 10)
    student = get_student(conn, "Alice")
    assert student is not None
    assert student[0] == "Alice"
    assert float(student[1]) == 10.0

def test_get_missing(conn):
    student = get_student(conn, "Inconnu")
    assert student is None

def test_moyenne(conn):
    add_student(conn, "Amel", 10)
    add_student(conn, "Karim", 14)
    assert average_grade(conn) == 12.0