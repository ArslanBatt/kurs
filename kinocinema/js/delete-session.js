 // Функция для подтверждения удаления  
 function confirmDelete(sessionId) {  
  if (confirm("Вы уверены, что хотите удалить этот сеанс?")) {  
    // Отправка AJAX-запроса на удаление (метод DELETE)
    fetch('../database/delete_session.php?id=' + sessionId, {
      method: 'DELETE'
    }) 
    .then(response => { 
      if (response.ok) { 
        // Успешное удаление, обновите таблицу или выполните другие действия 
        alert('Сеанс успешно удален!'); 
        // Например, можно перезагрузить страницу: 
        location.reload(); 
      } else { 
        // Обработка ошибок при удалении 
        alert('Произошла ошибка при удалении сеанса.'); 
      } 
    }) 
    .catch(error => { 
      console.error('Ошибка при отправке запроса на удаление:', error); 
      alert('Произошла ошибка при удалении сеанса.'); 
    }); 
  }  
}