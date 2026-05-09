function UserItem({ user }) {
  return (
    <li className="user-item">
      <h3>{user.name}</h3>
      <p>Email: {user.email}</p>
      <p>Город: {user.address.city}</p>
    </li>
  );
}

export default UserItem;
