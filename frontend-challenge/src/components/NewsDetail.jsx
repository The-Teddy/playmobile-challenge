import React, { useEffect, useState } from "react";
import { getNewsDetail } from "./helpers/Api";
import { useParams } from "react-router-dom";
import "./News.scss";
import { Link } from "react-router-dom";

const NewsDetail = () => {
  const [data, setData] = useState({});
  const { id } = useParams();
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    setLoading(true);
    getNewsDetail(id)
      .then((res) => {
        setData(res.data);
      })
      .catch((error) => {})
      .finally(() => {
        setLoading(false);
      });
  }, [id]);

  return (
    <>
      {loading ? (
        <p className="loading">Loading...</p>
      ) : (
        <div className="news-detail">
          <button>
            <Link to="/">Voltar para a listagem</Link>
          </button>

          {data ? (
            <>
              <p className="title">{data?.attributes?.title}</p>
              <p className="description">{data?.attributes?.description}</p>
              <p className="dates">
                <span>
                  Data de Publicação: {data?.attributes?.schedule?.publication}
                </span>
                <span>
                  {data.attributes?.schedule?.deadline ? (
                    <>
                      Prazo para envio de propostas:{" "}
                      {data.attributes?.schedule?.deadline}
                    </>
                  ) : (
                    <></>
                  )}

                  {}
                </span>
              </p>
            </>
          ) : (
            <h1>
              Ops...
              <br />
              Página não encontrada
            </h1>
          )}
        </div>
      )}
    </>
  );
};

export default NewsDetail;
