from flask import Flask, request, jsonify
from ai_matcher import calculate_similarity

app = Flask(__name__)

@app.route("/match", methods=["POST"])
def match_text():
    data = request.get_json()
    score = calculate_similarity(data["text1"], data["text2"])
    return jsonify({"success": True, "score": score})

app.run()