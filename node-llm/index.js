const axios = require('axios');

// STEP 1: Fetch latest article
async function fetchLatestArticle() {
  const response = await axios.get('http://127.0.0.1:8000/api/articles');
  return response.data[0];
}

// STEP 2: Simulate Google search
function getGoogleReferenceArticles(title) {
  return [
    {
      title: 'How AI Chatbots Improve Business Efficiency',
      url: 'https://example.com/ai-chatbots-business-efficiency'
    },
    {
      title: 'Choosing the Right AI Chatbot for Your Company',
      url: 'https://example.com/choosing-ai-chatbot'
    }
  ];
}

// STEP 3: Simulate LLM rewrite
function simulateLLMRewrite(originalArticle, references) {
  return `
## ${originalArticle.title} (Enhanced Version)

AI-powered chatbots are reshaping modern businesses by improving efficiency,
customer engagement, and decision-making.

### Why This Matters
Businesses that adopt conversational AI can scale support, reduce costs,
and deliver consistent user experiences.

### Improved Content
${originalArticle.content.substring(0, 500)}...

### References
${references.map(ref => `- ${ref.title} (${ref.url})`).join('\n')}
`;
}

// STEP 4: Publish generated article to Laravel
async function publishGeneratedArticle(content, references) {
  const response = await axios.post(
    'http://127.0.0.1:8000/api/articles',
    {
      title: 'AI Chatbots for Business – Enhanced',
      content: content,
      type: 'generated',
      source_url: references.map(r => r.url).join(', ')
    },
    {
      headers: {
        'Content-Type': 'application/json'
      }
    }
  );

  return response.data;
}

async function main() {
  try {
    const article = await fetchLatestArticle();
    const references = getGoogleReferenceArticles(article.title);

    const enhancedContent = simulateLLMRewrite(article, references);

    const savedArticle = await publishGeneratedArticle(
      enhancedContent,
      references
    );

    console.log('\nGenerated article published successfully!');
    console.log('New Article ID:', savedArticle.id);
  } catch (error) {
    console.error('Error:', error.message);
  }
}

main();
