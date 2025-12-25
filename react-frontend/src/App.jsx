import { useEffect, useState } from 'react';
import axios from 'axios';
import './App.css';

function App() {
  const [articles, setArticles] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios
      .get('http://127.0.0.1:8000/api/articles')
      .then((response) => {
        setArticles(response.data);
        setLoading(false);
      })
      .catch((error) => {
        console.error('Error fetching articles:', error);
        setLoading(false);
      });
  }, []);

  if (loading) {
    return <div className="container">Loading articles...</div>;
  }

  return (
    <div className="container">
      <h1>BeyondChats Articles</h1>

      {articles.map((article) => (
        <div key={article.id} className="article-card">
          <h2>{article.title}</h2>

          <span
            className={
              article.type === 'generated'
                ? 'badge badge-generated'
                : 'badge badge-original'
            }
          >
            {article.type}
          </span>

          <p className="content">
            {article.content.substring(0, 300)}...
          </p>

          {article.source_url && (
            <p className="source">
              <strong>Source:</strong> {article.source_url}
            </p>
          )}
        </div>
      ))}
    </div>
  );
}

export default App;
