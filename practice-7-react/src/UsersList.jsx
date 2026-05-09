import { useEffect, useState } from "react";
import UserItem from "./UserItem.jsx";

function UsersList() {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  useEffect(() => {
    fetch("https://jsonplaceholder.typicode.com/users")
      .then((response) => {
        if (!response.ok) {
          throw new Error();
        }

        return response.json();
      })
      .then((data) => {
        setUsers(data);
        setLoading(false);
      })
      .catch(() => {
        setError("Ошибка загрузки данных");
        setLoading(false);
      });
  }, []);

  if (loading) {
    return <p className="message">Загрузка...</p>;
  }

  if (error) {
    return <p className="message error">{error}</p>;
  }

  return (
    <section className="users-section">
      <h2>Пользователи из API</h2>
      <ul className="users-list">
        {users.map((user) => (
          <UserItem key={user.id} user={user} />
        ))}
      </ul>
    </section>
  );
}

export default UsersList;
