const myData = {
    id: 1,
    content: "content",
  };
  
  const option = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(myData),
  };
  
  fetch("http://server-ip.com", option).then((res) => {
    // 생략
  });