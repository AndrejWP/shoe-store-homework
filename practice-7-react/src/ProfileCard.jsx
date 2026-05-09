import { useState } from "react";

function ProfileCard() {
  const [avatar, setAvatar] = useState("");

  const handleAvatarChange = (event) => {
    const file = event.target.files[0];

    if (file) {
      setAvatar(URL.createObjectURL(file));
    }
  };

  return (
    <div className="profile-card">
      <h1>Моя визитка</h1>

      <div className="avatar">
        {avatar ? <img src={avatar} alt="Аватар" /> : <span>А</span>}
      </div>

      <label className="upload-button">
        Загрузить аватарку
        <input type="file" accept="image/*" onChange={handleAvatarChange} />
      </label>

      <h2>Потрикеев Андрей Сергеевич</h2>
      <p>Специальность: Информатика и вычислительная техника</p>
      <p>Группа: БИВТ-24-2</p>

      <ul>
        <li>Учебный проект по основам React.</li>
        <li>Компонент показывает данные студента и выбранную аватарку.</li>
      </ul>
    </div>
  );
}

export default ProfileCard;
