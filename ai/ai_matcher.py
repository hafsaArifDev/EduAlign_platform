from sentence_transformers import SentenceTransformer, util

# Load model once (FAST & FREE)
model = SentenceTransformer('sentence-transformers/all-MiniLM-L6-v2')

def calculate_similarity(text1: str, text2: str) -> float:
    """
    Returns similarity score between 0 and 1
    """
    if not text1 or not text2:
        return 0.0

    emb1 = model.encode(text1, convert_to_tensor=True)
    emb2 = model.encode(text2, convert_to_tensor=True)

    score = util.cos_sim(emb1, emb2).item()
    return round(score, 4)