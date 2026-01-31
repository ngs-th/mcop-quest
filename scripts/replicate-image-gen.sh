#!/bin/bash
#
# Replicate Image Generation Script for MCOP Quest
# Uses flux-pixel-art model for consistent RPG pixel art assets
#

set -e

# Configuration
REPLICATE_API_TOKEN="${REPLICATE_API_TOKEN:-}"
MODEL_VERSION="cd1c6a3dc86d63f25dac9f23329a9cbab8b84a76c3ca0bd5f1af47111813d77d"  # flux-pixel-art

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_error() {
    echo -e "${RED}❌ $1${NC}"
}

print_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_info() {
    echo -e "${YELLOW}ℹ️  $1${NC}"
}

# Check if API token is set
check_api_token() {
    if [ -z "$REPLICATE_API_TOKEN" ]; then
        print_error "REPLICATE_API_TOKEN is not set!"
        echo "Please set it with: export REPLICATE_API_TOKEN='your_token_here'"
        echo "Get your token from: https://replicate.com/account/api-tokens"
        exit 1
    fi
}

# Generate image using Replicate API
generate_image() {
    local prompt="$1"
    local output_file="$2"
    local width="${3:-512}"
    local height="${4:-512}"

    print_info "Generating image: $output_file"
    print_info "Prompt: $prompt"
    print_info "Size: ${width}x${height}"

    # Create prediction
    local response=$(curl -s -X POST \
        -H "Authorization: Token $REPLICATE_API_TOKEN" \
        -H "Content-Type: application/json" \
        -d "{
            \"version\": \"$MODEL_VERSION\",
            \"input\": {
                \"prompt\": \"$prompt\",
                \"width\": $width,
                \"height\": $height,
                \"guidance_scale\": 7.5,
                \"num_inference_steps\": 28
            }
        }" \
        https://api.replicate.com/v1/predictions)

    # Extract prediction ID
    local prediction_id=$(echo "$response" | grep -o '"id": "[^"]*"' | head -1 | cut -d'"' -f4)

    if [ -z "$prediction_id" ]; then
        print_error "Failed to create prediction"
        echo "Response: $response"
        return 1
    fi

    print_info "Prediction ID: $prediction_id"

    # Poll for completion
    local max_attempts=60
    local attempt=0
    local status="starting"

    while [ "$status" != "succeeded" ] && [ "$status" != "failed" ] && [ $attempt -lt $max_attempts ]; do
        sleep 2
        attempt=$((attempt + 1))

        local poll_response=$(curl -s -H "Authorization: Token $REPLICATE_API_TOKEN" \
            "https://api.replicate.com/v1/predictions/$prediction_id")

        status=$(echo "$poll_response" | grep -o '"status": "[^"]*"' | head -1 | cut -d'"' -f4)

        if [ $((attempt % 5)) -eq 0 ]; then
            print_info "Still generating... (attempt $attempt)"
        fi
    done

    if [ "$status" != "succeeded" ]; then
        print_error "Generation failed or timed out"
        echo "Final response: $poll_response"
        return 1
    fi

    # Get output URL
    local output_url=$(echo "$poll_response" | grep -o '"output": \["[^"]*"\]' | grep -o '"https://[^"]*"' | tr -d '"')

    if [ -z "$output_url" ]; then
        print_error "No output URL found"
        return 1
    fi

    # Download image
    curl -s -L "$output_url" -o "$output_file"

    # Check file type
    local file_type=$(file -b "$output_file")
    local file_size=$(du -h "$output_file" | cut -f1)

    print_success "Image saved: $output_file"
    print_info "Type: $file_type"
    print_info "Size: $file_size"

    return 0
}

# Main script
main() {
    check_api_token

    # Parse arguments
    if [ $# -lt 2 ]; then
        echo "Usage: $0 <prompt> <output_file> [width] [height]"
        echo ""
        echo "Examples:"
        echo "  $0 'pixel art castle RPG style' castle.png"
        echo "  $0 'pixel art tower' tower.png 512 512"
        echo ""
        echo "Environment:"
        echo "  REPLICATE_API_TOKEN - Your Replicate API token"
        exit 1
    fi

    local prompt="$1"
    local output_file="$2"
    local width="${3:-512}"
    local height="${4:-512}"

    # Create output directory if needed
    local output_dir=$(dirname "$output_file")
    if [ "$output_dir" != "." ] && [ ! -d "$output_dir" ]; then
        mkdir -p "$output_dir"
    fi

    generate_image "$prompt" "$output_file" "$width" "$height"
}

main "$@"
