import React, { useEffect, useState } from "react";
import { getNews } from "./helpers/Api";
import { Link } from "react-router-dom";
import "./News.scss";

const NewsList = () => {
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    setLoading(true);
    getNews()
      .then((res) => {
        setData(res.data);
      })
      .catch((error) => {})
      .finally(() => {
        setLoading(false);
      });
  }, []);

  return (
    <>
      {loading ? (
        <p className="loading">Loading...</p>
      ) : (
        <main className="news-list">
          {data.length === 0 ? (
            <h1>Não há contéudo a ser exibido</h1>
          ) : (
            <ul>
              <li>
                <div className="header-box">
                  <span>Título</span>
                  <span>Data de Publicação</span>
                </div>
              </li>
              {data?.map((item, index) => (
                <Link to={`/notice/finep/${item.id}`} className="links">
                  <li key={index}>
                    <span>{item.attributes.title.split("", 90)}...</span>
                    <span>{item.attributes.schedule.publication}</span>
                  </li>
                </Link>
              ))}
            </ul>
          )}
        </main>
      )}
    </>
  );
};

export default NewsList;
